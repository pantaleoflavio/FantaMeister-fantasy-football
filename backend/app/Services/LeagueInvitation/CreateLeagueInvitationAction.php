<?php

namespace App\Services\LeagueInvitation;

use App\Enums\LeagueInvitationStatus;
use App\Exceptions\LeagueInvitationCapacityExceeded;
use App\Models\League;
use App\Models\LeagueInvitation;
use App\Models\User;
use App\Services\LeagueInvitation\InvitationCodeGenerator;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CreateLeagueInvitationAction
{
    private const MAX_CODE_COLLISION_ATTEMPTS = 10;
    private const CODE_UNIQUE_CONSTRAINT = 'league_invitations_code_unique';

    public function __construct(
        private readonly InvitationCodeGenerator $codeGenerator
    ) {}

    public function handle(League $league, User $creator, array $data): LeagueInvitation
    {
        for (
            $attempt = 0;
            $attempt < self::MAX_CODE_COLLISION_ATTEMPTS;
            $attempt++
        ) {
            $code = $this->codeGenerator->generate();

            try {
                return DB::transaction(
                    function () use (
                        $league,
                        $creator,
                        $data,
                        $code
                    ): LeagueInvitation {
                        $lockedLeague = League::query()
                            ->whereKey($league->id)
                            ->lockForUpdate()
                            ->firstOrFail();

                        $remainingCapacity = max(
                            0,
                            $lockedLeague->max_participants
                                - $lockedLeague->memberships()->count()
                        );

                        if (
                            isset($data['max_uses'])
                            && $data['max_uses'] > $remainingCapacity
                        ) {
                            throw LeagueInvitationCapacityExceeded::forRemainingCapacity();
                        }

                        return LeagueInvitation::query()->create([
                            'league_id' => $lockedLeague->id,
                            'created_by_user_id' => $creator->id,
                            'code' => $code,
                            'status' => LeagueInvitationStatus::Active,
                            'max_uses' => $data['max_uses'] ?? null,
                            'used_count' => 0,
                            'expires_at' => $data['expires_at'] ?? null,
                        ]);
                    }
                );
            } catch (UniqueConstraintViolationException $exception) {
                if (
                    ! $this->isInvitationCodeUniqueViolation($exception)
                    || $attempt === self::MAX_CODE_COLLISION_ATTEMPTS - 1
                ) {
                    throw $exception;
                }
            }
        }

        throw new RuntimeException(
            'Unable to generate a unique invitation code.'
        );
    }

    private function isInvitationCodeUniqueViolation(
        UniqueConstraintViolationException $exception
    ): bool {
        return str_contains(
            $exception->getMessage(),
            self::CODE_UNIQUE_CONSTRAINT
        );
    }
}
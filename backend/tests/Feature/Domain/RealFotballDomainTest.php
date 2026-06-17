<?php

namespace Tests\Feature\Domain;

use App\Enums\CompetitionType;
use App\Models\Matchday;
use App\Models\Player;
use App\Models\PlayerRole;
use App\Models\PlayerSeasonRegistration;
use App\Models\RealClub;
use App\Models\RealCompetition;
use App\Models\RealMatch;
use App\Models\Season;
use App\Models\SeasonClub;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RealFotballDomainTest extends TestCase
{
    use RefreshDatabase;

    public function test_competition_type_is_enum_backed_and_code_is_unique(): void
    {
        $competition = RealCompetition::factory()->create(['type' => CompetitionType::DomesticCup, 'code' => 'cup']);
        $this->assertSame(CompetitionType::DomesticCup, $competition->type);
        $this->expectException(QueryException::class);
        RealCompetition::factory()->create(['code' => 'cup']);
    }

    public function test_season_club_derives_competition_and_rejects_duplicate_participation(): void
    {
        $season = Season::factory()->create();
        $club = RealClub::factory()->create();
        $participation = SeasonClub::factory()->create(['season_id' => $season, 'real_club_id' => $club]);
        $this->assertTrue($participation->season->realCompetition->is($season->realCompetition));
        $this->expectException(QueryException::class);
        SeasonClub::factory()->create(['season_id' => $season, 'real_club_id' => $club]);
    }

    public function test_registration_identifies_context_through_season_club_and_owns_role_and_quotation(): void
    {
        $registration = PlayerSeasonRegistration::factory()->create(['quotation' => 25.50]);
        $this->assertInstanceOf(Player::class, $registration->player);
        $this->assertInstanceOf(PlayerRole::class, $registration->playerRole);
        $this->assertInstanceOf(RealClub::class, $registration->seasonClub->realClub);
        $this->assertInstanceOf(Season::class, $registration->seasonClub->season);
        $this->assertInstanceOf(RealCompetition::class, $registration->seasonClub->season->realCompetition);
        $this->assertSame('25.50', $registration->quotation);
    }

    public function test_matchday_derives_competition_and_has_no_ambiguous_status(): void
    {
        $matchday = Matchday::factory()->create(['name' => null]);
        $this->assertTrue($matchday->season->realCompetition->is($matchday->season->realCompetition));
        $this->assertArrayNotHasKey('status', $matchday->getAttributes());
    }

    public function test_real_match_rejects_same_club_and_cross_season_clubs(): void
    {
        $matchday = Matchday::factory()->create();
        $home = SeasonClub::factory()->create(['season_id' => $matchday->season_id]);
        try {
            RealMatch::factory()->create(['matchday_id' => $matchday, 'home_season_club_id' => $home, 'away_season_club_id' => $home]);
            $this->fail('Same club accepted.');
        } catch (ValidationException) {
        }
        $this->expectException(ValidationException::class);
        RealMatch::factory()->create(['matchday_id' => $matchday, 'home_season_club_id' => $home, 'away_season_club_id' => SeasonClub::factory()->create()]);
    }
}

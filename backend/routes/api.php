<?php

use App\Http\Controllers\Api\V1\AcceptLeagueInvitationController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\LeagueController;
use App\Http\Controllers\Api\V1\LeagueInvitationController;
use App\Http\Controllers\Api\V1\LeagueMemberController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::get('/health', static fn () => response()->json([
        'status' => 'ok',
        'competition' => config('competition.code'),
    ]));

    // Authentication routes
    Route::prefix('auth')->group(function (): void {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);

        Route::middleware('auth:sanctum')->group(function (): void {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/me', [AuthController::class, 'me']);
        });
    });

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('/league-invitations/{code}', [AcceptLeagueInvitationController::class, 'show'])->name('api.v1.league-invitations.show');
        Route::post('/league-invitations/{code}/accept', [AcceptLeagueInvitationController::class, 'accept'])->name('api.v1.league-invitations.accept');
    });

    Route::prefix('leagues')->middleware('auth:sanctum')->group(function (): void {
        // League routes
        Route::get('/', [LeagueController::class, 'index']);
        Route::post('/', [LeagueController::class, 'store']);
        Route::get('/{league}', [LeagueController::class, 'show'])->middleware('can:view,league');
        Route::patch('/{league}', [LeagueController::class, 'update'])->middleware('can:update,league');
        Route::delete('/{league}', [LeagueController::class, 'destroy'])->middleware('can:delete,league');
        Route::get('/{league}/members', [LeagueMemberController::class, 'index'])->middleware('can:view,league');
        Route::get('/{league}/invitations', [LeagueInvitationController::class, 'index'])->name('api.v1.leagues.invitations.index');
        Route::post('/{league}/invitations', [LeagueInvitationController::class, 'store'])->name('api.v1.leagues.invitations.store');
        Route::delete('/{league}/invitations/{invitation}', [LeagueInvitationController::class, 'destroy'])->name('api.v1.leagues.invitations.destroy');
    });
});

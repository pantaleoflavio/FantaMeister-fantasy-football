<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\League\LeagueMemberResource;
use App\Models\League;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LeagueMemberController extends Controller
{
    public function index(League $league): AnonymousResourceCollection
    {
        return LeagueMemberResource::collection(
            $league->memberships()->with(['role', 'user'])->paginate()
        );
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Community;
use App\Models\CommunityMembership;
use App\Models\CommunityGroup;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $community_id = $request->route('community_id');
        $community_group_id = $request->route('community_group_id');

        $memberships = $user->communityMemberships()->get();

        $community = NULL;
        $group = NULL;
        $membership = NULL;

        if (isset($community_id)) {
            $community = Community::where('id', $community_id)->first();

            if (!isset($community)) {
                $community = $memberships[0]->community->first();
            }
       } else  {
            $community = $memberships[0]->community->first();
       }

       if (isset($community_group_id)) {
        $group = CommunityGroup::where('id', $community_group_id)->first();

        if (!isset($group)) {
            $group = $community->communityGroups()->where('is_default', true)->first();
        }
       } else {
        $group = $community->communityGroups()->where('is_default', true)->first();
       }

       $membership = $group->communityMemberships()->where('user_id', $user->id)->first();

        return Inertia::render('Community/Index', [
            'memberships' => $memberships,
            'community' => $community,
            'group' => $group,
            'membership' => $membership,
        ]);
    }
}

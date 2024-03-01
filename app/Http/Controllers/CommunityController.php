<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMembership;
use App\Models\CommunityGroup;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;


class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        $communityId = $request->route('communityId');
        $groupId = $request->route('groupId');

        $memberships = $user->communityMemberships()->with(['community'])->get();

        $community = NULL;
        $group = NULL;
        $groups = NULL;

        if (isset($communityId)) {
            $community = Community::where('id', $communityId)->first();

            if ($community) {
                $groups = CommunityGroup::where('community_id', $communityId)->whereHas('communityMemberships', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->get();
    
                if (isset($groupId)) {
                    $group = CommunityGroup::where('id', $groupId)->first();
    
                    if (!$group) {
                        $group = $groups->where('is_default', true)->get();
                    }
                    }
                }  
            }

        return Inertia::render('Community/Index', [
            'memberships' => $memberships,
            'community' => $community,
            'groups' => $groups,
            'group' => $group,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:256',
            'description' => 'required|string|max:256',
        ]);

        // create community
        $community = $request->user()->communities()->create($validated);

        // create membership as admin
        $communityMembership = new CommunityMembership();
        $communityMembership->user_id = $request->user()->id;
        $communityMembership->is_admin = true;
        $communityMembership->community_id = $community->id;
        $communityMembership->save();

        // create default group: `general`
        $communityGroup = new CommunityGroup();
        $communityGroup->is_default = true;
        $communityGroup->name = 'general';
        $communityGroup->community_id = $community->id;
        $communityGroup->save();

        $communityMembership->communityGroups()->attach($communityGroup->id);


        return redirect(route('community.show', ['id' => $community->id]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Community $community)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Community $community)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Community $community): RedirectResponse
    {
        $this->authorize('update', $community);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $community->update($validated);

        return redirect(route('community.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Community $community): RedirectResponse
    {
        $this->authorize('delete', $community);

        $community->delete();

        return redirect(route('community.index'));
    }
}

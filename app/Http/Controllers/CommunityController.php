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
        //
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
    public function store(Request $request, Community $Community): RedirectResponse
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


        return redirect(route('dashboard', ['community_id' => $community->id]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Community $community)
    {
        // check if admin
        $user = $request->user();

        $membership = $user->communityMemberships()->where('community_id', $community->id)->first();

        if (!$membership->is_admin) {
            return redirect(route('dashboard', ['community' => $community->id]));
        }
        // generate invite link
        $invite_link = "https://example.com";

        // show

        return Inertia::render('Community/Show', [
            'community' => $community,
            'invite_link' => $invite_link
        ]);
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

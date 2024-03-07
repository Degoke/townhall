<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostContent;
use App\Models\CommunityGroup;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function store(Request $request, CommunityGroup $community_group)
    {
        $validated = $request->validate([
            'title' => 'string|max:256',
            'text_content' => 'required|string|max:256',
        ]);

        $user = $request->user();
        // $groupId = $request->route('group_id');

        // $group = CommunityGroup::where('id', $groupId)->first();

        if (!Isset($community_group)) {
            abort(400, 'invalid group');
        }

        // check if user is admin of group

        $membership = $community_group->communityMemberships()->where('user_id', $user->id)->first();

        if (!isset($membership) || !$membership->is_admin) {
            abort(403, 'unauthorized');
        }

        $post = new Post();
        $post->user_id = $user->id;
        $post->community_group_id = $community_group->id;
        $post->save();

        $post_content = new PostContent();
        $post_content->title = $validated['title'];
        $post_content->text_content = $validated['text_content'];
        $post_content->post_id = $post->id;
        $post_content->save();

        $community = $membership->community->first();

        return redirect(route('dashboard', [
            'community' => $community->id,
            'community_group' => $community_group->id
        ]))->with('status', 'Post created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}

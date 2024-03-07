<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Community;
use App\Models\CommunityMembership;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): Response
    {
        $community_id = $request->route('community_id');
        if (isset($community_id)) {
            $community = Community::where('id', $community_id)->first();

            if (!isset($community)) {
                abort(400, 'invalid community');
            }
        }

        return Inertia::render('Auth/Register', [
            'community_id' => $community_id
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $community_id = $request->route('community_id');
        $community = NULL;
        $community_group = NULL;

        if (isset($community_id)) {
            $community = Community::where('id', $community_id)->first();

            if (!isset($community)) {
                abort(400, 'invalid community');
            }

            $community_group = $community->communityGroups()->where('is_default', true)->first();
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        if (isset($community_id)) {
            $communityMembership = new CommunityMembership();
            $communityMembership->user_id = $user->id;
            $communityMembership->is_admin = false;
            $communityMembership->community_id = $community->id;
            $communityMembership->save();

            $communityMembership->communityGroups()->attach($community_group->id);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}

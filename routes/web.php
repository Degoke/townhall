<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::Resource('community_group.post', PostController::class)->shallow()-> middleware(['auth', 'verified']);

Route::Resource('community', CommunityController::class)
    -> only(['store', 'show'])
    -> middleware(['auth', 'verified']);

/// ui routes
Route::get('/dashboard/{community?}/{community_group?}', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/community/new', function () {
    return Inertia::render('Community/New');
})->middleware(['auth', 'verified'])->name('community.new');

Route::get('/post/new/{group_id}', function () {
    $group_id = request()->route('group_id');

    return Inertia::render('Community/NewPost', [
        'group_id' => $group_id
    ]);
})->middleware(['auth', 'verified'])->name('post.new');

require __DIR__.'/auth.php';

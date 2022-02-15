<?php

namespace App\Http\Controllers;

use App\Models\Kweek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class KweekController extends Controller
{
    public function index()
    {
        $kweeks = Kweek::with([
            'user' => fn($query) => $query->withCount([
                'followers as is_followed' => fn($query) 
                => $query -> where('follower_id', auth()->user()->id)
            ])
            ->withCasts(['is_followed' => 'boolean'])
        ])->orderBy('created_at', 'DESC')->get();
        
        return Inertia::render('Kweek/Index', [
            'kweeks' => $kweeks,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'max:280'],
            'user_id' => ['exists:users,id'],
        ]);

        Kweek::create([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id,
        ]);

        return Redirect::route('kweeks.index');
    }

    public function followings()
    {
        $followings = Kweek::with('user')
        ->whereIn('user_id', auth()->user()->followings->pluck('id')->toArray())
        ->orderBy('created_at', 'DESC')
        ->get();

        return Inertia::render('Kweek/Followings', [
            'followings' => $followings,
        ]);
    }

    public function follows(User $user)
    {
        auth()->user()->followings()->attach($user->id);
        return Redirect::route('kweeks.index');
    }

    public function unfollows(User $user)
    {
        auth()->user()->followings()->detach($user->id);
        return Redirect()->back();
    }

    public function profile(User $user)
    {
        $profileUser = $user->loadCount([
            'followings as is_following_you' => 
                fn($q) => $q->where('following_id', auth()->user()->id)
                ->withCasts(['is_foolowing_you' => 'boolean']),
            'followers as is_followed' => 
                fn($q) => $q -> where('follower_id', auth()->user()->id)
                ->withCasts(['is_followed' => 'boolean']),
        ]);

        $kweeks = $user->kweeks;

        return Inertia::render('Kweek/Profile', [
            'profileUser' => $profileUser,
            'kweeks' => $kweeks,
        ]);
    }
}

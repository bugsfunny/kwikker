<?php

namespace App\Http\Controllers;

use App\Models\Kweek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class KweekController extends Controller
{
    public function index()
    {
        $kweeks = Kweek::with('user')->orderBy('created_at', 'DESC')->get();
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
}

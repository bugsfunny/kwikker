<?php

namespace App\Http\Controllers;

use App\Models\Kweek;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KweekController extends Controller
{
    public function index()
    {
        $kweeks = Kweek::with('user')->get();
        return Inertia::render('Kweek/Index', [
            'kweeks' => $kweeks,
        ]);
    }
}

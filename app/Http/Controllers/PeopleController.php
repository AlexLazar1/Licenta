<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;

class PeopleController extends Controller
{
    public function index()
    {
        return Inertia::render('People/Index', [
            'followers' => Auth::user()->followers,
            'following' => Auth::user()->following
        ]);
    }
}

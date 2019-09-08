<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Library;
use App\Models\Book;
use App\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $libraries = Library::where('user_id', Auth::user()->id)->count();
        $books = Book::where('user_id', Auth::user()->id)->count();
        $city = Auth::user()->city;
        $country = Auth::user()->country;

        $authors = Book::select('author', 'user_id')
            ->where('user_id', Auth::user()->id)
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('author')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
        
        $ratings = Book::select('title', 'rating', 'user_id')
            ->where('user_id', Auth::user()->id)
            ->groupBy('rating')
            ->orderByDesc('rating')
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard/Index', [
            'libraries' => $libraries,
            'books' => $books,
            'country' => $country,
            'city' => $city,
            'authors' => $authors,
            'ratings' => $ratings
        ]);
    }
}

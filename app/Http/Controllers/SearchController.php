<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Models\Book;
use Geodistance\Location;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->latitude) {
            Auth::user()->updateLocation(Request::ip());
        }

        $bookResults = Book::with('user')
            ->whereLike('title', Request::input('keywords'))
            ->whereLike('author', Request::input('keywords'))
            ->whereHas("user", function ($query) {
                $query->whereNotNull('phone_number')->where('city', '=', Auth::user()->city);
            })
            ->paginate();

        foreach($bookResults as $book) {
            $book->distance = $this->meters($book->user->location, Auth::user()->location);
        };

        return Inertia::render('Search/Index', [
            'paginated_search_results' => $bookResults,
        ]);
    }

    function meters(Location $x, Location $y, int $precision = 0)
    {
        $deltaLatitude = $y->latitude() - $x->latitude();
        $deltaLongitude = $y->longitude() - $x->longitude();

        $angle = asin(
            sqrt(
                pow(sin($deltaLatitude * 0.5), 2)
                + cos($x->latitude()) * cos($y->latitude())
                * pow(sin($deltaLongitude * 0.5), 2)
            )
        ) * 2;

        return round(Location::EARTH_RADIUS * $angle, $precision);
    }

    function kilometers(Location $x, Location $y, int $precision = 0)
    {
        return round(meters($x, $y) * 0.001, $precision);
    }
}

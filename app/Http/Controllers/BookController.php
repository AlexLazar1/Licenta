<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Library;
use App\Models\Book;

class BookController extends Controller
{

    public function create(Library $library)
    {
        return Inertia::render('Book/Create', [
            'library' => $library
        ]);
    }

    public function store(Library $library)
    {
        Request::validate([
            'isbn' => 'required|unique:books,isbn,NULL,id,user_id,'.Auth::user()->id
        ]);

        $url = "https://www.goodreads.com/book/isbn/" . trim(Request::input('isbn')) . "?key=" . env('GOODREADS_API_KEY');
        
        $file_headers = @get_headers($url);
        if( $file_headers[0] == 'HTTP/1.1 404 Not Found')
        {
            return Redirect::back()->withErrors('isbn_invalid');
        } 
        

        $contents = file_get_contents($url);
        $book_XML = simplexml_load_string($contents);
        $book_JSON = json_decode(json_encode($book_XML));

        $authors = '';
        if ((array) $book_JSON->book->authors && is_array($book_JSON->book->authors->author)) {
            foreach ($book_JSON->book->authors->author as $key => $author) {
                $authors .= $author->name . (!($key == count($book_JSON->book->authors->author) - 1) ? ', ' : '');
            }
        } 
        else if (is_string($book_JSON->book->authors->author)) {
            $authors = $book_JSON->book->authors->author->name;
        }

        $title = '';
        if (is_string($book_JSON->book->title)) {
            $title = $book_JSON->book->title;
        }
        else if (is_string($book_JSON->book->work->original_title)) {
            $title = $book_JSON->book->work->original_title;
	}

	$image_url = is_string($book_JSON->book->image_url) ? $book_JSON->book->image_url : '';
	$publication_day = is_string($book_JSON->book->work->original_publication_day) ? $book_JSON->book->work->original_publication_day :  '';
	$publication_month = is_string($book_JSON->book->work->original_publication_month) ? $book_JSON->book->work->original_publication_month : '';
	$publication_year = is_string($book_JSON->book->work->original_publication_year) ? $book_JSON->book->work->original_publication_year : '';
	$publisher = is_string($book_JSON->book->publisher) ? $book_JSON->book->publisher : '';
	$rating = is_string($book_JSON->book->average_rating) ? $book_JSON->book->average_rating : '';
	
        $book = new Book();
        $book->isbn = Request::input('isbn');
        $book->user_id = Auth::user()->id;
        $book->library_id = $library->id;
        $book->title = $title;
        $book->author = $authors;
        $book->image_url = $image_url;
        $book->publication_day = $publication_day;
        $book->publication_month = $publication_month;
        $book->publication_year = $publication_year;
        $book->publisher = $publisher;
        $book->rating = $rating;
        $book->save();

        return Redirect::route('libraries.books', $library->id)->with('success', 'Library created.');
    }

    public function edit(Book $book)
    {
        return Inertia::render('Book/Edit', [
            'book' => $book
        ]);
    }

    public function update(Book $book)
    {
        $book->title = Request::input('title');
        $book->author = Request::input('author');
        $book->publication_day = Request::input('publication_day');
        $book->publication_month = Request::input('publication_month');
        $book->publication_year = Request::input('publication_year');
        $book->publisher = Request::input('publisher');
        $book->save();

        return Redirect::route('libraries.books', $book->library->id)->with('success', 'Library updated.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return Redirect::route('libraries.books', $book->library->id)->with('success', 'Book deleted.');
    }

    public function restore(Book $book)
    {
        $book->restore();

        return Redirect::route('libraries.books', $book->library->id)->with('success', 'Book restored.');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Library;
use App\User;

class Book extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'ISBN'
  ];

  public function library() {
    return $this->belongsTo(Library::class);
  }

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function getBookInfo(){
    $url = "https://www.goodreads.com/book/isbn/" . $this->ISBN . "?key=" . env('GOODREADS_API_KEY');
    $contents = file_get_contents($url);
    $book_XML = simplexml_load_string($contents);
    $book_JSON = json_decode(json_encode($book_XML));

    return $book_JSON;
  }


}

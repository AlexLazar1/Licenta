<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Relationship extends Model
{
  use SoftDeletes;

  public function sender(){
    return $this->belongsTo(User::class);
  }

  public function receiver(){
    return $this->belongsTo(User::class);
  }
}

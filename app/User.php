<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Geodistance\Location;
use App\Models\Relationship;
use App\Models\Library;
use App\Models\Book;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use SoftDeletes, Authenticatable, Authorizable;

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getLocationAttribute() {
        return new Location($this->latitude, $this->longitude);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('last_name')->orderBy('first_name');
    }

    protected $appends = ['name', 'location'];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function followers() {
        return $this->hasMany(Relationship::class, 'receiver_id');
    }

    public function following() {
        return $this->hasMany(Relationship::class, 'sender_id');
    }

    public function libraries() {
        return $this->hasMany(Library::class);
    }

    public function books() {
        return $this->hasMany(Book::class);
    }

    public function updateLocation($ip) {
        $location = geoip($ip);

        $this->country = $location->country;
        $this->city = $location->city;
        $this->latitude = $location->lat;
        $this->longitude = $location->lon;
        $this->save();
    }

}

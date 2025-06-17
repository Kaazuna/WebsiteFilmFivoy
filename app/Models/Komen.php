<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komen extends Model
{
    protected $fillable = ['user_id','film_id', 'komen'];
    public function user()
    {
        return $this->belongsTo(User::class);    
    }
    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}

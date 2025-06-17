<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = ['judul','foto','deskripsi','views'];
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'film_genre');
    }

    public function komen()
    {
        return $this->hasMany(Komen::class);
    }

    public function sukaFilm()
    {
        return $this->belongsToMany(User::class, 'sukai')->withTimestamps();
    }
}

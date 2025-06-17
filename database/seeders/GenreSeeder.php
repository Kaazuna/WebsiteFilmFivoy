<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Genre;


class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = ['Action', 'Comedy', 'Drama', 'Horror'];

        foreach ($genres as $genre){
            Genre::create(['genre' => $genre]);
        }
    }
}

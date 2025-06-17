<?php

namespace Database\Seeders;

use App\Models\User; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        User::factory()->create([
            'name'      => 'admin',
            'email'     => 'admin@gmail.com',                   
            'role'      => 'admin',
            'password'  => bcrypt('admin123'),
        ]);
    }
}

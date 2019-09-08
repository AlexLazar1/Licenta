<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create([
            'first_name' => 'Aldo',
            'last_name' => 'Dumitrescu',
            'email' => 'aldodumitrescu@gmail.com'
        ]);

        factory(User::class, 5)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Territory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        //City::factory()->has(Territory::factory()->count(5))->create();
    }
}

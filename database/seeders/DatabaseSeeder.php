<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Territory;
use App\Models\User;
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
        User::factory(1)->create();
        City::factory()->has(Territory::factory()->count(5))->create();
    }
}

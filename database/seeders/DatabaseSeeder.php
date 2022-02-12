<?php

namespace Database\Seeders;

use App\Models\Kweek;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create()->each(
            fn (User $user) => $user->kweeks()->saveMany(Kweek::factory(5)->make())
        );
    }
}

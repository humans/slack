<?php

use App\Team;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            ['name' => 'Artisan.ph', 'slug' => 'artisanph'],
        ];

        array_walk($teams, [Team::class, 'create']);
    }
}

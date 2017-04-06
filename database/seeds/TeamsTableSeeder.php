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
            ['name' => 'Wilderborn', 'slug' => 'wilderborn'],
        ];

        array_walk($teams, [Team::class, 'create']);
    }
}

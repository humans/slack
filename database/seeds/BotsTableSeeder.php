<?php

use Illuminate\Database\Seeder;

use App\Bot;

class BotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bots = [
            ['username' => 'slackbot'],
        ];

        array_map([Bot::class, 'create'], $bots);
    }
}

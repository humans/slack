<?php

use App\Team;
use App\Channel;
use Illuminate\Database\Seeder;

class ChannelsTableSeeder extends Seeder
{
    public function run()
    {
        $channels = [
            ['name' => 'general'],
            ['name' => 'random'],
        ];

        array_walk($channels, function ($channel) {
            Channel::create($channel + ['team_id' => Team::first()->id]);
        });
    }
}

<?php

use Illuminate\Database\Seeder;

use App\Channel;

class ChannelsTableSeeder extends Seeder
{
    public function run()
    {
        $channels = [
            ['name' => 'general'],
            ['name' => 'random'],
        ];

        array_map([Channel::class, 'create'], $channels);
    }
}

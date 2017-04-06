<?php

use App\Team;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'jaggy',
                'name' => 'Jaggy Gauran',
                'email' => 'i.am@jag.gy',
                'password' => '123456',
                'team_id' => Team::first()->id,
            ]
        ];

        array_walk($users, [User::class, 'create']);
    }
}

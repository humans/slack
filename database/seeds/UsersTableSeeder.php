<?php

use Illuminate\Database\Seeder;

use App\User;

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
                'name' => 'Jaggy Gauran',
                'email' => 'i.am@jag.gy',
                'password' => bcrypt('123456'),
            ]
        ];

        array_map([User::class, 'create'], $users);
    }
}

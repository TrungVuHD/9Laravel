<?php

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
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('secret'),
            'username' => 'john',
            'show_nsfw' => true,
            'show_upvote' => true,
            'gender' => 1,
            'country' => 'Romania',
            'birthday_year' => 1990,
            'birthday_month' => 1,
            'birthday_day' => 1,
            'description' => 'A regular John Doe',
        ]);
        DB::table('users')->insert([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('secret'),
            'username' => 'jane',
            'show_nsfw' => true,
            'show_upvote' => true,
            'gender' => 0,
            'country' => 'Romania',
            'birthday_year' => 1990,
            'birthday_month' => 1,
            'birthday_day' => 1,
            'description' => 'A regular Jane Doe',
        ]);
        DB::table('users')->insert([
            'name' => 'Florian Stancioiu',
            'email' => 'florian@superbrackets.com',
            'password' => bcrypt('secret'),
            'username' => 'florian',
            'show_nsfw' => true,
            'show_upvote' => true,
            'gender' => 1,
            'country' => 'Romania',
            'birthday_year' => 1990,
            'birthday_month' => 1,
            'birthday_day' => 1,
            'description' => 'A not so regular developer',
        ]);

        factory(App\User::class, 1000)->create();
    }
}

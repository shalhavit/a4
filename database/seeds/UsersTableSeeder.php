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
        // Reset the users table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();

        // generate 3 users/author
        DB::table('users')->insert([
            [
                'name' => "Daniel Baldemus",
                'email' => "baldamusdaniel@gmail.com",
                'password' => bcrypt('secret')
            ],
            [
                'name' => "Icnelly Pineda",
                'email' => "icnelly.pineda@gmail.com",
                'password' => bcrypt('secret')
            ],
            [
                'name' => "Patricia del Castillo",
                'email' => "patricia.delcastillor@gmail.com",
                'password' => bcrypt('secret')
            ],
        ]);
    }
}

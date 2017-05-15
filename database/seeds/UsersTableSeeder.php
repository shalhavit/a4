<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

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
        $faker = Factory::create();

        DB::table('users')->insert([
            [
                'name' => "Test user",
                'slug' => "test-user",
                'email' => "test@gmail.com",
                'password' => bcrypt('test'),
                'bio' => $faker->text(rand(250, 300))
            ],
            [
                'name' => "Icnelly Pineda",
                'slug' => "icnelly-pineda",
                'email' => "icnelly.pineda@gmail.com",
                'password' => bcrypt('secret'),
                'bio' => $faker->text(rand(250, 300))
            ],
            [
                'name' => "Patricia del Castillo",
                'slug' => "patricia-castillo",
                'email' => "patricia.delcastillor@gmail.com",
                'password' => bcrypt('secret'),
                'bio' => $faker->text(rand(250, 300))
            ],
        ]);
    }
}

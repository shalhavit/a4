<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('categories')->truncate();

        DB::table('categories')->insert([
            [
                'title' => 'Mexico Unplugged',
                'slug' => 'mexico-unplugged'
            ],
            [
                'title' => 'Yucatan Highlights',
                'slug' => 'yucatan-highlights'
            ],
            [
                'title' => 'Real Food Adventure',
                'slug' => 'real-food-adventure'
            ],
            [
                'title' => 'Mysteries of the Mayan World',
                'slug' => 'mysteries-mayan-world'
            ],
            [
                'title' => 'Magical Mexico',
                'slug' => 'magical-mexico'
            ],
        ]);

        // update the posts data
        for ($post_id = 1; $post_id <= 10; $post_id++)
        {
            $category_id = rand(1, 5);

            DB::table('posts')
                ->where('id', $post_id)
                ->update(['category_id' => $category_id]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Http\Services\PostService::createDirs();
        factory(App\Post::class, 150)->create();
    }
}

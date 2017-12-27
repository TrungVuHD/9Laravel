<?php

use Illuminate\Database\Seeder;
use App\Http\Services\PostService;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostService::createDirs();

        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(PointsTableSeeder::class);
    }
}

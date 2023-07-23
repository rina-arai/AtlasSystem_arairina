<?php

use Illuminate\Database\Seeder;
use App\Models\Posts\Post;

class MainCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('main_categories')->insert([
        [
            'main_category'=> '教科',
        ]]);
    }
}

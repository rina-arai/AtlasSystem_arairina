<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 各テーブルへのデータの流し込みを呼び出す
        $this->call(UsersTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(SubjectUsersSeeder::class);
        $this->call(MainCategoriesTableSeeder::class);
        $this->call(SubCategoriesTableSeeder::class);
        $this->call(re_settingsTableSeeder::class);
        $this->call(re_set_usersTableSeeder::class);

    }
}

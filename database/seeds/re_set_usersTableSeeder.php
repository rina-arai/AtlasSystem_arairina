<?php

use Illuminate\Database\Seeder;

class re_set_usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reserve_setting_users')->insert([
        [
            'user_id'=> '8',
            'reserve_setting_id'=> '1',
        ]
        ]);
    }
}

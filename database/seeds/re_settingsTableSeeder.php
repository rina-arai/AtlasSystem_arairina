<?php

use Illuminate\Database\Seeder;

class re_settingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reserve_settings')->insert([
        [
            'setting_reserve'=> '2023-08-03',
            'setting_part'=> '1',
        ],[
            'setting_reserve'=> '2023-08-21',
            'setting_part'=> '1',
        ],[
            'setting_reserve'=> '2023-08-21',
            'setting_part'=> '2',
        ],[
            'setting_reserve'=> '2023-08-30',
            'setting_part'=> '1',
        ],[
            'setting_reserve'=> '2023-08-31',
            'setting_part'=> '2',
        ]
        ,[
            'setting_reserve'=> '2023-08-24',
            'setting_part'=> '1',
        ],[
            'setting_reserve'=> '2023-08-24',
            'setting_part'=> '2',
        ]
        ]);
    }
}

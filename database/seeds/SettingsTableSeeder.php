<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [
            [
                'name' => 'light',
                'user_id' => 1,
                'status' => 1
            ]

        ];
        DB::table('tbl36b12_settings')->insert($setting);
    }
}

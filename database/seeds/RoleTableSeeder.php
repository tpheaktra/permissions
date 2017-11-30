<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'name' => 'admin',
                'display_name' => 'administrator',
                'description' => 'Control all system'
            ]
            
        ];
        DB::table('tbl36b12_roles')->insert($role);
    }
}

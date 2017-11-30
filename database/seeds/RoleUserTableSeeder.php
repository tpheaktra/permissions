<?php

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = [
            [
                'user_id' => 1,
                'role_id' => 1,
            ]
            
        ];
        DB::table('tbl36b12_role_user')->insert($role_user);
    }
}

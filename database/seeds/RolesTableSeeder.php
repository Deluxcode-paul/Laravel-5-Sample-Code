<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateTime = Carbon::now()->toDateTimeString();
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'User'],
            ['name' => 'Top Professional Chef'],
            ['name' => 'Community Chef'],
        ];

        if (0 == DB::table('roles')->count()) {
            foreach ($roles as $role) {
                $role['created_at'] = $role['updated_at'] = $dateTime;
                DB::table('roles')->insert($role);
            }
        }
    }
}

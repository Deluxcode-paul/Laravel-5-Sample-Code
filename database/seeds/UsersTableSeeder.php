<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateTime = Carbon::now()->toDateTimeString();

        if (0 == DB::table('users')->count()) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'admin',
                'first_name' => 'Admin',
                'email' => 'admin@kosher.com',
                'password' => Hash::make('1qaz2wsx'),
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ]);

            DB::table('roles')->insert([
                'role_id' => 1,
                'user_id' => $userId
            ]);
        }
    }
}

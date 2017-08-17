<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'administrator',
            'first_name' => 'my first name',
            'last_name' => 'my last name',
            'password' => bcrypt('administrator'),
            'role' => '1',
        ]);
    }
}

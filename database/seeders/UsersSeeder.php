<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Events\UserSaved;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user = User::firstOrCreate([
        	'prefixname' => 'Mr',
			'firstname' => 'Admin',
			'middlename' => 'A',
			'lastname' => 'Admin',
			'suffixname' => 'Admin',
			'username' => 'admin',
			'email' => 'admin@gmail.com',
			'type' => 'O',
			'password' => Hash::make('*-unwW]V:S;A8e<{')
        ]);


       $event = event(new UserSaved($user));
    }
}

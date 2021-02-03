<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
	    DB::table('users')->insert([
	    	'active'    => 1,
		    'email'     => 'webmaster@site.com',
		    'password'  => Hash::make('admin'),
	    ]);
	    DB::table('users')->insert([
	    	'active'    => 1,
		    'email'     => 'admin@site.com',
		    'password'  => Hash::make('admin'),
	    ]);
	    DB::table('users')->insert([
	    	'active'    => 1,
		    'email'     => 'coach@site.com',
		    'password'  => Hash::make('admin'),
	    ]);
	    DB::table('users')->insert([
	    	'active'    => 1,
		    'email'     => 'companyowner@site.com',
		    'password'  => Hash::make('admin'),
	    ]);
	    DB::table('users')->insert([
	    	'active'    => 1,
		    'email'     => 'user@site.com',
		    'password'  => Hash::make('admin'),
	    ]);
    }
}

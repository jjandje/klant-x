<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('companies')->insert([
		    'active'    => 1,
		    'name'      => 'Company 1',
		    'logo'      => null,
	    ]);
	    DB::table('companies')->insert([
		    'active'    => 1,
		    'name'      => 'Company 2',
		    'logo'      => null,
	    ]);
	    DB::table('companies')->insert([
		    'active'    => 1,
		    'name'      => 'Company 3',
		    'logo'      => null,
	    ]);
	    DB::table('companies')->insert([
		    'active'    => 0,
		    'name'      => 'Inactive company',
		    'logo'      => null,
	    ]);
    }
}

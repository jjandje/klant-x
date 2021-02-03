<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('packages')->insert([
	    	    'active'    => 1,
			    'highlight' => 0,
			    'title'     => 'Pakket 1',
			    'slug'      => 'pakket-1',
			    'content'   => 'content',
			    'price'     => 2,
			    'price_per' => 'per medewerker per maand',
			    'bonus'     => null,
		    ]);
	    DB::table('packages')->insert([
		        'active'    => 1,
			    'highlight' => 1,
			    'title'     => 'Pakket 2',
			    'slug'      => 'pakket-2',
			    'content'   => 'content',
			    'price'     => 3,
			    'price_per' => 'per medewerker per maand',
			    'bonus'     => null,
		    ]);
	    DB::table('packages')->insert([
			    'active'    => 1,
			    'highlight' => 0,
			    'title'     => 'Pakket 3',
			    'slug'      => 'pakket-3',
			    'content'   => 'content',
			    'price'     => 5,
			    'price_per' => 'per medewerker per maand',
			    'bonus'     => 'Bonus: Elk half jaar een uitje',
		    ]);
    }
}

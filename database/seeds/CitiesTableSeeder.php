<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$city = new City();
        $city->name = 'barahona';
        
        $cityTwo = new City();
        $cityTwo->name = 'santiago';
        
        $cityThree = new City();
        $cityThree->name = 'santo domingo';*/

        DB::table('cities')->insert([
          'name' => 'santiago'
        ]);
        DB::table('cities')->insert([
          'name' => 'barahona'
        ]);
        DB::table('cities')->insert([
          'name' => 'santo domingo'
        ]);
    }
}

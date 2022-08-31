<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CitiesTableSeeder::class);
        factory(App\Profession::class, 3)->create();
        factory(App\User::class, 3)->create();
        factory(App\Address::class, 3)->create();
        factory(App\Technician::class, 3)->create();
        factory(App\Job::class, 3)->create();
        factory(App\Ranking::class, 3)->create();
        factory(App\Technician_profession::class, 3)->create();

    }
}

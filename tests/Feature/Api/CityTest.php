<?php

namespace Tests\Feature\Api;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\City;

class CityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        //$this->withoutExceptionHandling();

        //insert data in test DB
        factory(City::class, 1)->create();
        //Hitting api route
        $response = $this->getJson('/api/city');
        //dd($response->json());
        $this->assertEquals(1, count($response->json()));
    }
}


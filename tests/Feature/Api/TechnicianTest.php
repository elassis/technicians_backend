<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Technician;
use App\City;
use App\Address;
use App\User;


class TechnicianTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected $tech;

    //this function initialize all the preparation of the test avoiding the repetition of the code
    public function setUp():void 
    {
        parent::setUp();
        factory(City::class, 1)->create();
      
        factory(User::class, 2)->create();
        
        factory(Address::class, 1)->create();       
        
        $this->tech = factory(Technician::class, 1)->create();
    }
    
     public function test_index()
     {  
         $this->withoutExceptionHandling();
      
         $response = $this->getJson('api/index');

         $this->assertEquals(1, count($response->json()));
     }

    public function test_show()
    {
        $this->withoutExceptionHandling();
    
        $response = $this->getJson(route('technician.show', 1));
        
        $response->assertOk();

        $this->assertEquals($response->json()['id'], $this->tech[0]['id']);
    }

    // public function test_store()
    // {
    //     $this->withoutExceptionHandling();

    //     $response = $this->postJson(route('technician.store'), [
    //         'user_id'    => 2,
    //         'available'  => true,
    //         'price_hour' => 350
    //     ])->assertCreated();

    //     //dd($response->json()['price_hour']);

    //     $this->assertDatabaseHas('technicians', ['price_hour' => 350]);
    // }

    public function test_delete()
    {
        $this->deleteJson(route('technician.destroy', $this->tech[0]['id']))
        ->assertNoContent();

        $this->assertDatabaseMissing('technicians',[
            'price_hour' => $this->tech[0]['price_hour']
        ]);
    }

    public function test_update()
    {
        $this->putJson(route('technician.update',$this->tech[0]['id']),[
            'price_hour' => 200
        ]);

        $this->assertDatabaseHas('technicians',['price_hour' => 200]);
    }
}


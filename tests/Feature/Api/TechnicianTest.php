<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Technician;
use App\City;
use App\Address;
use App\User;
use Illuminate\Support\Facades\Hash;


class TechnicianTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected $tech;
    protected $user;
    protected $autUser;

    //this function initialize all the preparation of the test avoiding the repetition of the code
    public function setUp():void 
    {

      parent::setUp();
      $this->autUser = User::create([
        'first_name'     => 'enamnuel',
        'last_name'      => 'lassis',
        'identification' => '01800735258',
        'cellphone'      => '8095423454',
        'email'          => 'testEmail@gmail.com',
        'type'           => 'client',
        'password'       => Hash::make('rosa1007'),
      ]);
        $city = factory(City::class, 1)->create();
      
        $this->user = factory(User::class, 1)->create();

        factory(Address::class, 1)->create([
          'user_id' => $this->user[0]->id,
          'city_id' => $city[0]->id, 
        ]);       
        
        $this->tech = factory(Technician::class, 1)->create([
          'user_id' => $this->user[0]->id,
        ]);
    }
    
     public function test_index()
     {  
         $this->withoutExceptionHandling();        
      
         $response = $this->actingAs($this->autUser)->getJson('api/index');

         $this->assertEquals(1, count($response->json()));
     }

     public function test_show()
    {
        $this->withoutExceptionHandling();
    
        $response = $this->actingAs($this->autUser)->getJson(route('technician.show', $this->user[0]->id));
        
        $response->assertOk();
      
        $this->assertEquals($response->json()['data']['user_info']['user_id'], $this->tech[0]->user_id);
    }

    public function test_store()
    {
       $this->withoutExceptionHandling();

       $this->postJson(route('technician.store',[
           'user_id'    => $this->autUser->id,
           'available'  => true,
           'price_hour' => 350
       ]))->assertCreated();

         $this->assertDatabaseHas('technicians', ['id' => $this->autUser->id]);
     }

    public function test_delete()
    {
        $this->deleteJson(route('technician.destroy', $this->tech[0]['id']))
        ->assertNoContent();

        $this->assertDatabaseMissing('technicians',[
            'price_hour' => $this->tech[0]->id
        ]);
    }
 
    public function test_update()
    {
        $this->putJson(route('technician.update',$this->tech[0]['id']),[
            'available' => 0 ]);

        $this->assertDatabaseHas('technicians',['available' =>  0]);
    }
}


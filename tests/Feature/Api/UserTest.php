<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Hash;

use App\User;
use App\City;
use App\Address;

class UserTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    
    //this function initialize all the preparation of the test avoiding the repetition of the code
    public function setUp():void 
    {
        parent::setUp();
        factory(City::class, 1)->create();
      
        $this->user = factory(User::class, 1)->create();
        
        factory(Address::class, 1)->create();
       
        
        // $this->tech = factory(Technician::class, 1)->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show()
    {
        $this->withoutExceptionHandling();

        $autUser = User::create([
          'first_name'     => 'enamnuel',
          'last_name'      => 'lassis',
          'identification' => '01800735258',
          'cellphone'      => '8095423454',
          'email'          => 'testEmail@gmail.com',
          'type'           => 'client',
          'password'       => Hash::make('rosa1007'),
        ]);

        $response = $this->actingAs($autUser)->getJson(route('user.show',$this->user[0]->email));

        $response->assertOk();

        $this->assertEquals($response->json()['data']['user_info']['id'],$this->user[0]['id']);
    }
    
    public function test_store()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson(route('user.store'),[
            'first_name'     => 'enmanuel',
            'last_name'      => 'lassis',
            'identification' => '01800735258',
            'cellphone'      => '8294368573',
            'email'          => 'enmanuel@gmail.com',
            'password'       => 'rosa1007'
        ])->assertOk();

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('users', ['last_name' => 'lassis']);
    }

    public function test_update()
    {
        $this->withoutExceptionHandling();

        $this->putJson(route('user.update',$this->user[0]['id']),[
            'last_name' => 'pena',    
        ]);

        $this->assertDatabaseHas('users', ['last_name' => 'pena']);
    }

    public function test_delete()
    {
        $this->withoutExceptionHandling();

        $this->deleteJson(route('user.destroy',$this->user[0]['id']));

        $this->assertDatabaseMissing('users', ['last_name' => $this->user[0]['last_name']]);
    }
}

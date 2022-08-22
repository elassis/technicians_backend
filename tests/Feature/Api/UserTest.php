<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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

        $response = $this->getJson(route('user.show',1));

        //dd($response->json()['id']);

        $response->assertOk();

        $this->assertEquals($response->json()['id'],$this->user[0]['id']);
    }
    
    public function test_store()
    {
        $this->withoutExceptionHandling();

        $this->postJson(route('user.store'),[
            'first_name'     => 'enmanuel',
            'last_name'      => 'lassis',
            'identification' => '01800735258',
            'cellphone'      => '8294368573',
            'email'          => 'enmanuel@gmail.com',
            'password'       => 'rosa1007'
        ])->assertCreated();

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

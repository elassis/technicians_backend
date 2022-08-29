<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;
use App\City;
use App\Address;

class LoginTest extends TestCase
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
    public function testExample()
    {
      $this->withoutExceptionHandling();

        $response = $this->postJson(route('login',[
          'email'    => $this->user[0]['email'],
          'password' => $this->user[0]['password'],

        ]));
        dd($response);
        //$response->assertStatus(200);

        //$this->assertEqual($response->json())
    }
}

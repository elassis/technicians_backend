<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
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
      
        factory(User::class, 1)->create();
        
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

      $user = User::create([
        'first_name'     => 'enamnuel',
        'last_name'      => 'lassis',
        'identification' => '01800735258',
        'cellphone'      => '8095423454',
        'email'          => 'testEmail@gmail.com',
        'type'           => 'client',
        'password'       => Hash::make('rosa1007'),
      ]);

        $response = $this->postJson(route('login',[
          'email'    => $user->email,
          'password' => 'rosa1007',

        ]));
        
        $response->assertStatus(302);

    }
}

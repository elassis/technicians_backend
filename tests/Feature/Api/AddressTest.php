<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\City;
use App\User;
use App\Address;
use Tests\TestCase;

class AddressTest extends TestCase
{

    use RefreshDatabase;

    protected $address;

    public function setUp():void
    {
        parent::setUp();
        factory(City::class, 1)->create();
      
        factory(User::class, 2)->create();
        
        $this->address = factory(Address::class, 1)->create();       
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create()
    {
        $this->withoutExceptionHandling();

        $newUser = factory(User::class, 1)->create();
        $id = $newUser->toArray()[0]['id'];
        //dd($newUser->toArray()[0]['id']);
        
        $this->postJson(route('address.store'),[
            'user_id' => $id,
            'city_id' => 1,
            'street' => 'second',
            'sector' => 'camboya',
            'number' => '5'
        ])->assertCreated();

        $this->assertDatabaseHas('addresses',['sector' => 'camboya']);
    }
    public function test_show()
    {
        $this->withoutExceptionHandling();

        $response = $this->getJson(route('address.show', 1));

        $response->assertOk();

        $this->assertEquals($response->json()['id'],$this->address[0]['id']);
    }
    
    public function test_update()
    {
        $this->withoutExceptionHandling();

        $this->putJson(route('address.update',$this->address[0]['id']),[
            'sector' => 'alcarrizos'
        ]);

        $this->assertDatabaseHas('addresses',['sector' => 'alcarrizos']);
    }

    public function test_delete()
    {
        $this->withoutExceptionHandling();

        $this->deleteJson(route('address.destroy',$this->address[0]['id']));

        $this->assertDatabaseMissing('addresses',['id' =>$this->address[0]['id']]);
    }
}

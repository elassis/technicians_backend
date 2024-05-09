<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Technician_profession;
use App\User;
use App\City;
use App\Address;
use App\Technician;
use App\Profession;
use Illuminate\Support\Facades\Hash;

class Technician_professionTest extends TestCase
{
    use RefreshDatabase;

    protected $techpro;
    protected $tech;
    protected $pro;

    public function setUp():void
    {
        parent::setUp();
        factory(City::class, 1)->create();
        factory(User::class, 1)->create();
        factory(Address::class, 1)->create();
        $this->pro = factory(Profession::class, 1)->create();
        $this->tech = factory(Technician::class, 1)->create();
        $this->techpro = factory(Technician_profession::class, 1)->create();

    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show()
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

        $response = $this->actingAs($user)->getJson(route('tech_prof.show',$this->tech[0]['id']));
        /* dd($response->json()); */
        $this->assertEquals($response->json()['technician_id'],$this->tech[0]['id']);
    }

    public function test_create()
    {
        $this->withoutExceptionHandling();

        $testTechproData = [
          'technician_id' => $this->tech[0]['id'],
          'profession_id' => $this->pro[0]['id'],
          'price_hour'    => 50,
        ];

        //dd($testTechproData[0]['technician_id']);
        $this->postJson(route('tech_prof.store', $testTechproData))->assertOk();

        $this->assertDatabaseHas('technician_professions',
        ['technician_id' => $this->tech[0]['id']]);
    }

    public function test_delete()
    {
        $this->withoutExceptionHandling();

        $this->postJson(route('tech_prof.store'),[
          'technician_id' => $this->tech[0]['id'],
          'profession_id' => $this->pro[0]['id']
        ])->assertOk();

        $this->deleteJson(route('tech_prof.destroy',$this->tech[0]['id']))->assertOk();

        $this->assertDatabaseMissing('technician_professions',
        ['technician_id' => $this->tech[0]['id']]);
    }
}

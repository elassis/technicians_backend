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

        $response = $this->getJson(route('tech_prof.show',$this->tech[0]['id']));

        //dd($this->tech);

        $this->assertEquals($response->json()['technician_id'],$this->tech[0]['id']);
    }

    public function test_create()
    {
        $this->withoutExceptionHandling();

        $this->postJson(route('tech_prof.store'),[
            'technician_id' => $this->tech[0]['id'],
            'profession_id' => $this->pro[0]['id']
        ])->assertCreated();

        $this->assertDatabaseHas('technician_professions',
        ['technician_id' => $this->tech[0]['id']]);
    }

    public function test_delete()
    {
        $this->withoutExceptionHandling();

        $this->postJson(route('tech_prof.store'),[
          'technician_id' => $this->tech[0]['id'],
          'profession_id' => $this->pro[0]['id']
        ])->assertCreated();

        $this->deleteJson(route('tech_prof.destroy'),[
            'technician_id' => $this->tech[0]['id'],
        ])->assertOk();

        $this->assertDatabaseMissing('technician_professions',
        ['technician_id' => $this->tech[0]['id']]);
    }
}

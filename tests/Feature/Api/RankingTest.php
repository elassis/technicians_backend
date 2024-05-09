<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Job;
use App\User;
use App\City;
use App\Address;
use App\Profession;
use App\Technician;
use App\Ranking;
use Illuminate\Support\Facades\Hash;

class RankingTest extends TestCase
{
    use RefreshDatabase;

    protected $tech;
    protected $ranking;
    protected $job;

    public function setUp():void
    {
        parent::setUp();
        factory(City::class, 1)->create();
        factory(User::class, 1)->create();
        factory(Address::class, 1)->create();
        factory(Profession::class, 1)->create();
        $this->tech = factory(Technician::class, 1)->create();
        $this->job = factory(Job::class, 1)->create();
        $this->ranking = factory(Ranking::class, 1)->create();

    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store()
    {
        $this->withoutExceptionHandling();

        $localJob = factory(Job::class, 1)->create();
        $this->postJson(route('ranking.store'),[
            'technician_id' => $this->tech[0]['id'],
            'job_id'        => $localJob[0]['id'],
            'job_ranking'   => '4' 
        ])->assertCreated();

        $this->assertDatabaseHas('rankings',['job_ranking' => 4]);
    }

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

       $response = $this->actingAs($user)->getJson(route('ranking.show',$this->tech[0]['id']));
       $this->assertEquals($response->json()['job_ranking'], $this->ranking[0]['job_ranking']);
    }

    public function test_delete()
    {
        $this->withoutExceptionHandling();
        
        $this->deleteJson(route('ranking.destroy',$this->ranking[0]['id']));

        $this->assertDatabaseMissing('rankings',['job_ranking' => $this->ranking[0]['id']]);
    }
}

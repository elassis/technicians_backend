<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Job;
use App\User;
use App\City;
use App\Address;
use App\Technician;
use App\Ranking;

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

        $this->postJson(route('ranking.store'),[
            'technician_id' => $this->tech[0]['id'],
            'job_id'        => $this->job[0]['id'],
            'job_ranking'   => '4' 
        ])->assertCreated();

        $this->assertDatabaseHas('rankings',['job_ranking' => 4]);
    }

    public function test_show()
    {
       $this->withoutExceptionHandling();

       $response = $this->getJson(route('ranking.show',$this->tech[0]['id']));
       //dd($response);
       $this->assertEquals($response->json()['job_ranking'], $this->ranking[0]['job_ranking']);
    }

    public function test_delete()
    {
        $this->withoutExceptionHandling();
        
        $this->deleteJson(route('ranking.destroy',$this->ranking[0]['id']));

        $this->assertDatabaseMissing('rankings',['job_ranking' => $this->ranking[0]['id']]);
    }
}

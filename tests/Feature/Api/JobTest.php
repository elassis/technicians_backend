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

class JobTest extends TestCase
{
    use RefreshDatabase;

    protected $job;

    public function setUp():void
    {
        parent::setUp();
        factory(City::class, 1)->create();
        factory(User::class, 1)->create();
        factory(Address::class, 1)->create();
        factory(Technician::class, 1)->create();
        $this->job = factory(Job::class, 1)->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create()
    {
        $this->withoutExceptionHandling();

        $this->postJson(route('job.store'),[
            'user_id'       => 1,
            'technician_id' => 1,
            'comments'      => 'lorem ipsum'
        ])->assertCreated();

        $this->assertDatabaseHas('jobs',['comments' => 'lorem ipsum']);
    }

    public function test_show()
    {
        $this->withoutExceptionHandling();

        $response = $this->getJson(route('job.show',$this->job[0]['id']));

        $response->assertOk();
        //dd($response->json());

        $this->assertEquals($response->json()['id'], $this->job[0]['id']);
    }

    public function test_update()
    {
        $this->withoutExceptionHandling();

        $this->putJson(route('job.update',$this->job[0]['id']),[
            'comments' => 'The best ever'
        ]);

        $this->assertDatabaseHas('jobs',['comments' => 'The best ever']);
    }

    public function test_delete()
    {
        $this->withoutExceptionHandling();

        $this->deleteJson(route('job.destroy',$this->job[0]['id']));

        $this->assertDatabaseMissing('jobs', ['id' => 1]);
    }
}

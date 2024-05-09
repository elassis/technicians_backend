<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Job;
use App\City;
use App\Address;
use App\Technician;
use App\Profession;
use Illuminate\Support\Facades\Hash;

class JobTest extends TestCase
{
    use RefreshDatabase;

    protected $job;
    protected $user;
    protected $autUser;
    protected $profession;


    public function setUp():void
    {
        parent::setUp();
        factory(City::class, 1)->create();
        $this->user = factory(User::class, 1)->create();
        factory(Address::class, 1)->create();
        factory(Technician::class, 1)->create();
        $this->profession = factory(Profession::class, 1)->create();
        $this->job = factory(Job::class, 1)->create();
        $this->autUser = User::create([
          'first_name'     => 'enamnuel',
          'last_name'      => 'lassis',
          'identification' => '01800735258',
          'cellphone'      => '8095423454',
          'email'          => 'testEmail@gmail.com',
          'type'           => 'client',
          'password'       => Hash::make('rosa1007'),
      ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create()
    {
        $this->withoutExceptionHandling();
        //dd($this->profession[0]->id);

        $this->postJson(route('job.store'),[
            'technician_id' => 1,
            'profession_id' => $this->profession[0]->id,
            'user_id'       => 1,
            'text'          => 'lorem ipsum'
        ]);

        $this->assertDatabaseHas('jobs',['text' => 'lorem ipsum']);
        
    }
 
    public function test_show()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->autUser)->getJson(route('job.show',$this->job[0]['id']));

        $response->assertOk();

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

    public function testRankingComment()
    {
        $this->withoutExceptionHandling();

        $testPayload = [
          'id' => $this->job[0]->id,
          'comment' => 'testing comment',
          'ranking' => 5,
        ];

        $this->actingAs($this->autUser)->postJson(route('job.rankJob', $testPayload));

        $this->assertDatabaseHas('jobs', ['comments' => $testPayload['comment']]);
        $this->assertDatabaseHas('rankings', ['job_ranking' => $testPayload['ranking']]);

        
    }
}

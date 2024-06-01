<?php

namespace Tests\Feature;

use App\User;
use App\Job;
use App\City;
use App\Ranking;
use App\Address;
use App\Technician;
use Tests\TestCase;
use App\Profession;
use App\Services\JobService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobServiceTest extends TestCase
{

    use RefreshDatabase;

    protected $job;
    protected $user;
    protected $ranking;
    protected $profession;

    public function setUp(): void
    {
        parent::setUp();
        factory(City::class, 1)->create();
        $this->user = factory(User::class, 1)->create();
        factory(Address::class, 1)->create();
        factory(Technician::class, 1)->create();
        $this->profession = factory(Profession::class, 1)->create();
        $this->job = factory(Job::class, 1)->create();
    }

    /**
     * Testing show service's method.
     *
     * @return void
     */
    public function testShow()
    {
        $this->withoutExceptionHandling();

        $service = new JobService();

        $response = $service->show($this->job[0]->id);

        $this->assertEquals($response['id'], $this->job[0]->id);
    }

    /**
     * Testing update ranking and comment service's method.
     *
     * @return void
     */
    public function testRankingAndComment()
    {
        $this->withoutExceptionHandling();

        $service = new JobService();

        $dataToUpdate = [
            'ranking' => 2,
            'comment' => 'I like it',
        ];

        $service->storeCommentAndRanking($this->job[0]->id, $dataToUpdate);

        //Assertions
        // Comment added
        $this->assertDatabaseHas('jobs', ['comments' => 'I like it']);

        // Ranking updated
        $this->assertDatabaseHas('rankings', ['job_ranking' => 2]);
    }
}

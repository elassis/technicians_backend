<?php

namespace App\Http\Controllers;

use App\Job;
use App\User;
use App\Profession;
use App\Technician;
use App\Services\JobService;
use Illuminate\Http\Request;
use App\Events\JobRequested;
use App\Events\JobRequestReponse;
use App\Http\Requests\RankCommentJobRequest;
use App\Http\Resources\JobResource;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Job::create($request->all());

            // get technician email, customer name and profession
            $user = User::find($request->user_id);
            $profession = Profession::findOrFail($request->profession_id);
            $techEmail = Technician::findOrFail($request->technician_id)->user->email;
            $userFullname = $user->first_name . ' ' . $user->last_name;

            event(new JobRequested($userFullname, $techEmail, $profession->name));
        } catch (\Throwable $th) {
            return response($th, 500);
        }

        return response([
            'data'   => 'job successfully created',
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = new JobService();
        $jobInstance = $service->show($id);
        return response(new JobResource($jobInstance), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update job
        try {
            $job = Job::findOrFail($id);
            $job->update($request->all());

            $technician = $job->technician->user;

            $client = User::findOrFail($job->user_id);
            $customerMail = $client->email;

            $response = $request->status;

            $techInfo = [
                'name'  => $technician->first_name . ' ' . $technician->last_name,
                'phone' => $technician->cellphone,
                'email' => $technician->email
            ];

            event(new JobRequestReponse($techInfo, $customerMail, $response));
        } catch (\Throwable $th) {
            return response($th, 500);
        }


        return response([
            'data' => 'job successfully updated',
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Job::findOrFail($id)->delete();
        } catch (\Throwable $th) {
            response('there was an error', 500);
        }
        return response('', 204);
    }

    /**
     * Add the Ranking and comment to the source.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rankCommentJob(RankCommentJobRequest $request)
    {
        try {
            $jobService = new JobService();
            $validatedData = $request->validated();
            $jobId = $validatedData['id'];
            $jobService->storeCommentAndRanking($jobId, $validatedData);
        } catch (\Throwable $th) {
            return response($th, 500);
        }

        return response([
            'message' => 'job ranked successfully',
            'status' => 200,
        ]);
    }
}

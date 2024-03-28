<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Profession;
use App\Technician;
use App\Events\JobRequested;
use App\Events\JobRequestReponse;

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
        Job::create($request->all());
  
        // get technician email, customer name and profession  
        $user = User::find($request->user_id);
        $profession = Profession::findOrFail($request->profession_id);
        $tech_email = Technician::findOrFail($request->technician_id)->user->email;
        $_user = $user->first_name.' '.$user->last_name;      

        event(new JobRequested($_user, $tech_email, $profession->name));

        return response(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $received = DB::table('jobs')
       ->select('jobs.id','jobs.status','jobs.text','jobs.begin_date','jobs.end_date','users.first_name','users.last_name')
       ->join('users','jobs.user_id','=','users.id')
       ->where('jobs.technician_id','=', $id)
       ->get();
       $sent = DB::table('jobs')
       ->select('jobs.id','jobs.status','jobs.text','jobs.begin_date','jobs.technician_id','jobs.end_date','users.first_name','users.last_name')
       ->join('technicians','jobs.technician_id', '=', 'technicians.id')
       ->join('users','technicians.user_id','=','users.id')
       ->where('jobs.user_id','=', $id)
       ->get();
        return response([
          'received' => $received,
          'sent'     => $sent
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
                'name'  => $technician->first_name .' '.$technician->last_name,
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
        return response('',204);
    }

    
}

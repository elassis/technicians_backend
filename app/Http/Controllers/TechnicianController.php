<?php

namespace App\Http\Controllers;

use App\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $techs = DB::table('technicians')
        ->select(DB::raw('technicians.id as id, users.first_name, users.last_name, technicians.available, AVG(rankings.job_ranking) as ranking'))
        ->join('users', 'technicians.user_id', '=', 'users.id')
        ->leftJoin('rankings','rankings.technician_id','=','technicians.id')
        ->groupBy('id')
        ->having('technicians.available','=', 1)
        ->get();
        return $techs;
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
        // $tech = Technician::create([
        //     'user_id'    => $request->user_id,
        //     'available'  => $request->available,
        //     
        // ]);
        $tech = Technician::create($request->all());
        return $tech;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function show(Technician $id)
    {
       //$tech = Technician::find($id);
       //$tech = Technician::findOrFail($id);//send a message 
       $tech = DB::table('technicians')
                  ->join('users','technicians.user_id','=','users.id')
                  ->select('technicians.id','users.first_name','users.last_name')
                  ->where('technicians.id','=', $id->id)
                  ->get();

        $prof = DB::table('technician_professions')
                  ->join('professions','technician_professions.profession_id','=','professions.id')
                  ->select('professions.id','professions.name')
                  ->where('technician_professions.technician_id','=',$id->id)
                  ->get();
        
         $jobs = DB::table('jobs')
                  ->join('professions','jobs.profession_id','=','professions.id')
                  ->join('rankings','jobs.id','=','rankings.job_id')
                  ->select('jobs.id','professions.name','rankings.job_ranking',)
                  ->where('jobs.technician_id','=', $id->id)
                  ->get();
                  
        return [$tech, $prof, $jobs];//oneline thanks to the route binding
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function edit(Technician $technician)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Technician $id)
    {
        //$request->validate(['price_hour' => 'required']);//validation before proceed
        $id->update($request->all());
        return response($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technician $id)
    {
        $id->delete();
        return response('', 204);
    }
}

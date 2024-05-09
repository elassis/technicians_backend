<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Technician_profession;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TechnicianJobsResource;
use App\Technician;

class Technician_professionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Technician_profession::all();
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
            $allData = $request->all();
            $techId = $allData[0]['technician_id'];
            $techEntity = Technician::findOrFail($techId);
          	foreach($allData as $technicianData){
            	Technician_profession::create($technicianData);
          	}
        } catch (\Throwable $th) {
          	return $th;
        }

        return response()->json([
            'data'   => new TechnicianJobsResource($techEntity),
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
      return Technician_profession::findOrFail($id);   
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
        //
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
            $entity = Technician_profession::findOrFail($id);
            $tech = $entity->technician;
            $entity->delete();
          } catch (\Throwable $th) {
            return response('there was an error', 500);
          }

        return response()->json([
            'data'   =>  new TechnicianJobsResource($tech),
            'status' => 204
            
        ]);  
    }
}

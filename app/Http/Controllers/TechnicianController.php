<?php

namespace App\Http\Controllers;

use App\Http\Resources\TechnicianJobsResource;
use App\Http\Resources\TechnicianResourse;
use App\Technician;
use Illuminate\Database\Eloquent\Collection;
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
        $allTecnicians = Technician::all();
        $tecnicians = TechnicianResourse::collection($allTecnicians);
        $techniciansCollection = collect($tecnicians);
        $sorted = $techniciansCollection->sortByDesc('rankingAvg');

        return $sorted->values()->all();
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
    public function show($id)
    {
        $tech = Technician::findOrFail($id);
        
        return response()->json([
          'data' => new TechnicianJobsResource($tech),
          'status' => 200,
        ]);
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

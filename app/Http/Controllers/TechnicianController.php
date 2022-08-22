<?php

namespace App\Http\Controllers;

use App\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Technician::all()
            ->where('available', 1);
        return response($users);
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
        //     'price_hour' => $request->price_hour
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
        return response($id);//oneline thanks to the route binding
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
        $request->validate(['price_hour' => 'required']);//validation before proceed
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

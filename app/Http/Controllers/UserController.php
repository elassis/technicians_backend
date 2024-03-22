<?php

namespace App\Http\Controllers;

use App\Http\Resources\TechnicianResourse;
use App\Http\Resources\UserResource;
use App\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'This is the login';
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
       
        $user = user::create([
          'first_name'     => $request->first_name,
          'last_name'      => $request->last_name,
          'identification' => $request->identification,
          'cellphone'      => $request->cellphone,
          'email'          => $request->email,
          'password'       => Hash::make($request->password),
        ]);
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        $user = User::where('email', $email)->first();
        $data = new UserResource($user);
        if($data){
            return $data;
        }
        return null;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $id)
    {
        try {
            $id->update($request->all());
            $id->address->update($request->all());
            
            if($id->type == 'client'){
              $user = new UserResource($id);
            }else{
              $tech = $id->techinician;
              $user = ['user_info' => new TechnicianResourse($tech)];
            }
        } catch (\Throwable $th) {
              throw $th;
        }
        
        return response()->json([
          'data' => $user,
          'status' => 200,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $id)
    {
        $id->delete();
        return response('',204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\TechnicianResourse;
use App\Http\Resources\UserResource;
use App\Technician;
use App\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        try{
            $user = User::create([
                'first_name'     => $request->first_name,
                'last_name'      => $request->last_name,
                'identification' => $request->identification,
                'cellphone'      => $request->cellphone,
                'email'          => $request->email,
                'type'           => $request->type,
                'password'       => Hash::make($request->password),
            ]);
            $user->address()->create($request->all());

            if(count($request->professions) > 0){
                $tech = $user->technician()->create($request->all());
                foreach($request->professions as $profession){
                    $tech->technicianProfession()->create($profession);
                }
            }

       }catch(\Throwable $th){
            return $th;
       }

        return response([
            'data' =>  new UserResource($user),
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        try{
            $user = User::where('email', $email)->first();
            $userData = new UserResource($user);
        }catch(\Throwable $th){
            return $th;
        }
        
        return response([
            'data' => $userData,
            'status' => 202,
        ]);
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
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());
            $user->address->update($request->all());
            
            if($user->type == 'client'){
                $userResponse = new UserResource($user);
            }else{
                $tech = $user->technician;
                $userResponse = ['user_info' => new TechnicianResourse($tech)];
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }
        
        return response()->json([
          'data' => $userResponse,
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
        return response('', 204);
    }
}

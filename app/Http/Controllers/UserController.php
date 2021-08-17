<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return response()->json([
                'data' => User::all(),
                'message' => 'Success'
            ],200);

        }catch(Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
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
            $validator = Validator::make($request->all(),
                ['name'             => 'required',
                    'date_of_birth' => 'required|date',
                    'email'         => 'required|email',
                    'country'       => 'required',
                    'phone_number'  => 'numeric|min:900000000|max:999999999|digits:9'
                ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Invalid Input'], 500);
            }

            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->date_of_birth = $request->date_of_birth;
            $user->email = $request->email;
            $user->country = $request->country;
            $user->phone_number = $request->phone_number;
            $user->save();

            DB::commit();
            return response()->json([
                'data' => $user,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception){
            DB::rollBack();
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try{
            return response()->json([
                'data' => $user,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception){
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try{
            $validator = Validator::make($request->all(),
                [
                    'date_of_birth' => 'date',
                    'email'         => 'email',
                    'phone_number'  => 'numeric|min:900000000|max:999999999|digits:9'
                ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Invalid Input'], 500);
            }

            DB::beginTransaction();
            $user = User::find($user->id);
            $user->name          = $request->name!=""          ? $request->name          : $user->name;
            $user->date_of_birth = $request->date_of_birth!="" ? $request->date_of_birth : $user->date_of_birth;
            $user->email         = $request->email!=""         ? $request->email         : $user->email;
            $user->country       = $request->country!=""       ? $request->country       : $user->country;
            $user->phone_number  = $request->phone_number!=""  ? $request->phone_number  : $user->phone_number;
            $user->save();
            DB::commit();

            return response()->json([
                'data' => $user,
                'message' => 'Success'
            ], 200);

        } catch (Exception $exception){
            DB::rollBack();
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return response()->json(['message' => 'User Deleted'], 205);

        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception], 500);
        }
    }
}

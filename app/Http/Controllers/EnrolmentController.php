<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrolment;
use App\Models\TutoringClass;
use App\Models\User;


class EnrolmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Enrolment::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // check if user is student
        if (strcmp(auth()->user()->role, 'student') != 0)
            return response()->json(["message" => "Unauthorized."], 403);

        // check if id exists
        if (TutoringClass::select('id')->where('id', $id)->exists() == 0)
            return response()->json(['errors' => ['id' => ['The id is invalid.']]], 400);

        $user = User::find(auth()->user()->id);
        $class = TutoringClass::find($id);
        // add enrolment
        $user->tutoringClass()->attach($class);

        return Enrolment::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
    }
}

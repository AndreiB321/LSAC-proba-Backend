<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reviews::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check fields
        $request->validate([
            'message' => ['required', 'max:500'],
            'user_id' => 'required'
        ]);

        return Reviews::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // check if field exists
        if (Reviews::select('id')->where('id',$id)->exists())
            return Reviews::find($id);
        // error
        return response()->json(['errors' => ['id' => ['The id is invalid.']]], 404);
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
        // check if id exists
        if(Reviews::select('id')->where('id',$id)->exists() == 0)
            return response()->json(['errors' => ['id' => ['The id is invalid.']]], 404);
    
        // check if logged user updates its review
        if (auth()->user()->id != Reviews::where("id",$id)->get('user_id')->first()->user_id)
            return response()->json(["message" => "Unauthorized."], 403);
        
        // check if field exists 
        if ($request->has('message') == 0)
            return response()->json(['errors' => ['input' => ['The input is invalid.']]], 400);

        return Reviews::where('id', $id)->update(array('message' => $request->get('message')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // check if logged user deletes its review
        if (auth()->user()->id != $id)
            return response()->json(["message" => "Unauthorized."], 403);
        // check if review exists
        if (Reviews::select('id')->where('id',$id)->exists())
            return Reviews::destroy($id);
        return response()->json(['errors' => ['id' => ['The id is invalid.']]], 404);
    }
}

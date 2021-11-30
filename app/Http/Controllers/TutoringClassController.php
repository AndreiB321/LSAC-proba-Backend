<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TutoringClass;
use App\Models\User;

class TutoringClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tutoring = TutoringClass::all();

        if ($request->has('subject')) {
            return $tutoring->where('subject', $request->get('subject'))->values();
        }
        return TutoringClass::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'description' => ['required', 'max:500'],
            'subject' => ['required', 'max:80']
        ]);

        if (strcmp(User::where('id', auth()->user()->id)->first()->role, 'teacher') != 0) {
            return response()->json(["message" => "Unauthorized."], 403);
        }

        $tutoringClass = TutoringClass::create([
            'description' => $fields['description'],
            'subject' => $fields['subject'],
            'teacher_id' => auth()->user()->id,
        ]);
        return $tutoringClass;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (TutoringClass::select('id')->where('id',$id)->exists())
            return TutoringClass::find($id);
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
        if (!$request->has('description'))
            return response()->json(['errors' => ['input' => ['The input is invalid.']]], 400);

        if (TutoringClass::select('id')->where('id', $id)->exists() == 0)
            return response()->json(['errors' => ['id' => ['The id is invalid.']]], 404);

        if (auth()->user()->id != TutoringClass::where("id", $id)->get('teacher_id')->first()->teacher_id)
            return response()->json(["message" => "Unauthorized."], 403);

        return TutoringClass::where('id', $id)->update(array('description' => $request->get('description')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (TutoringClass::select('id')->where('id', $id)->exists() == 0)
            return response()->json(['errors' => ['id' => ['The id is invalid.']]], 404);

        if (auth()->user()->id != TutoringClass::where("id", $id)->get('teacher_id')->first()->teacher_id)
            return response()->json(["message" => "Unauthorized."], 403);
        return TutoringClass::destroy($id);
       
    }
}

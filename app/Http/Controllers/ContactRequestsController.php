<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactRequests;

class ContactRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contacts = ContactRequests::all();

        // check query
        if ($request->has('filterBy')) {
            // decode json
            $filterRequest = $request->get('filterBy');
            $fields = json_decode($filterRequest, true);
            
            // check fields
            if (array_key_exists('email', $fields)) {
                $contacts = $contacts->where('email', $fields['email'])->values();
            }

            if (array_key_exists('is_resolved', $fields)) {
                $contacts = $contacts->where('is_resolved', $fields['is_resolved'])->values();
            }
            
            if (array_key_exists('message', $fields)) {
                $contacts = $contacts->where('message', $fields['message'])->values();
            }

            return $contacts;
        }

        // check fields
        if ($request->has('sortBy') && $request->has('order')) {
            // verify fields
            if (preg_match('(email|id|name|message)', $request->get('sortBy')) === 1
                && preg_match('(desc|asc)', $request->get('order')) === 1) {
                return ContactRequests::orderBy($request->get('sortBy'), $request->get('order'))->get();
            }
        }
        return ContactRequests::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // verify fields
        $request->validate([
            'name' => ['required', 'max:50'],
            'email' =>['required', 'max:50'],
            'message' => ['required', 'max:5000'],
            'is_resolved' => 'sometimes|nullable'
        ]);

        // validate email
        $result = filter_var($request->get('email'), FILTER_VALIDATE_EMAIL);
        if ($result == false)
            return response()->json(['errors' => ['email' => ['The email is invalid.']]], 400);

        return ContactRequests::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // check if id exists
        if (ContactRequests::select('id')->where('id',$id)->exists())
            return ContactRequests::find($id);
        // send error
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
        // check field
        if ($request->get('is_resolved') == 'true' or $request->get('is_resolved') == 'false') {
            // check if id exists
            if (ContactRequests::select('id')->where('id',$id)->exists())
                return ContactRequests::where('id', $id)->update(array('is_resolved' => $request->get('is_resolved')));
            return response()->json(['errors' => ['Error occured.']], 404);
        }
        return response()->json(['errors' => ['input' => ['The input is invalid.']]], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // check if id exists
        if (ContactRequests::select('id')->where('id',$id)->exists())
            return ContactRequests::destroy($id);
        return response()->json(['errors' => ['id' => ['The id is invalid.']]], 404);
    }
}

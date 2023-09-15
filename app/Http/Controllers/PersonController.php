<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $person = Person::all();
        if ($person->isEmpty()) {
            return response()->json([
                "error" => "person is empty"
            ], 404);
            // http_response_code(404);
        };
        return PersonResource::collection($person);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonRequest $request)
    {
        //
        $person = new Person();
        $person->name = $request->name;
        $person->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $person = Person::where("id", $id)->get();
        if ($person->isEmpty()) {
            return  response()->json([
                "Error" => "Person with this id is not found"
            ]);
        };
        //    $person=Person::find($id)->get();
        return PersonResource::collection($person);

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonRequest $request,int $id)
    {
        //
        // return "Hello world";
        $person = Person::where("id", $id)->get();
        if ($person->isEmpty()) {
            return  response()->json([
                "Error" => "Person with this id is not found"
            ]);
        };

        $run = Person::where('id', $id)->update([
            'name' => $request->name
        ]);
        if (!$run) {
            return  response()->json([
                "Error" => "Something Went Wrong"
            ], 500);
        }
        return  response()->json([
            "Message" => "UPDATED SUCCESSFULLY"
        ], 200);

           $person=Person::find($id)->get();
        return PersonResource::collection($person);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id)
    {
        $person = Person::find($id);
        // $person=Person::where("id",$id)->get();
        if (!$person) {
            return  response()->json([
                "Error" => "Person with this id is not found"
            ]);
        }
        $person->delete();
        return  response()->json([
            "Success" => "Data deleted Successfully"
        ], 204);
        //
    }
}

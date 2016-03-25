<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Office;

use App\Http\Requests;

class OfficesController extends Controller
{
    public function index() {   
        return Office::all();
    }

    public function store(Request $request) {
        echo "string";
        $office = new Office;
        //var_dump($request->all());
        $office['attributes'] = $request->all();
        try {
            if($office->save()) {
                return Response::json(array(
                    "status" => 201,
                    "message" => "A new office has been created!",
                    "office" => $office,
                ), 201);
            } else {
                throw new Exception("Error Processing Request");
            }
        } catch(QueryException $e) {
            return Response::json(array(
                    "status" => 406,
                    "message" => $e->getMessage(),
                    "office" => $office,
            ), 406);
        }
    }

    public function show($id) {
        return Office::find($id);
    }

    public function update(Request $request, $id) {
        $office = Office::find($id);
        if(sizeof($office)) {
            $office->fill($request->all());
            try {
                if($office->save()) {
                    return Response::json(array(), 204);
                } else {
                    throw new Exception("Error Processing Request");
                }
            } catch(QueryException $e) {
                return Response::json(array(
                        "status" => 406,
                        "message" => $e->getMessage(),
                        "office" => $office,
                ), 406);
            }
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Office not found!"
            ), 404);
        }
    }

    public function destroy($id) {
        $office = Office::find($id);
        if(sizeof($office)) {
            $office->delete();
            return Response::json(array(), 204);
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Office not found!"
            ), 404);
        }
    }

    public function add_user($office_id, $user_id) {
        $office = Office::find($id);
        $office->users()->attach($user_id);
    }

}

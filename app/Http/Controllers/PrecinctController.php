<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Precinct;

use App\Http\Requests;

class PrecinctController extends Controller
{
    public function index(Request $request) {
        $precinct = new Precinct;
        $precinct->setConnection($request->header()['office-name'][0]);
        return $precinct->all();
    }

    public function store(Request $request) {
        $precinct = new Precinct;
        $precinct->setConnection($request->header()['office-name'][0]);
        $precinct['attributes'] = $request->all();
        try {
            if($precinct->save()) {
                return Response::json(array(
                    "status" => 201,
                    "message" => "A new precinct has been created!",
                    "precinct" => $precinct
                ), 201);
            } else {
                throw new Exception('Error processing request!');
            }
        } catch(QueryException $e) {
            return Response::json(array(
                    "status" => 406,
                    "message" => $e->getMessage(),
                    "precinct" => $precinct,
            ), 406);
        }
    }

    public function update(Request $request, $id) {
        $precinct = new Precinct;
        $precinct->setConnection($request->header()['office-name'][0]);
        $precinct = $precinct->find($id);
        if(sizeof($precinct)) {
            $precinct->fill($request->all());
            try {
                if($precinct->save()) {
                      return Response::json(array(
                          "status" => 200,
                          "message" => "A precinct has been updated successfully!",
                          "precinct" => $precinct
                        ), 200);
                } else {
                      throw new Exception("Error Processing Request");
                }
            } catch(QueryException $e) {
                return Response::json(array(
                        "status" => 406,
                        "message" => $e->getMessage(),
                        "precinct" => $precinct,
                ), 406);
            }
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Precinct not found!"
            ), 404);
        }
    }

    public function destroy(Request $request, $id) {
        $precinct = new Precinct;
        $precinct->setConnection($request->header()['office-name'][0]);
        $precinct = $precinct->find($id);
        if(sizeof($precinct)) {
            $precinct->delete();
            return Response::json(array(
                          "status" => 200,
                          "message" => "An precinct has been deleted successfully!",
                          "precinct" => $precinct
                        ), 200);
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Precinct not found!"
            ), 404);
        }
    }

    public function show(Request $request, $id) {
        $precinct = new Precinct;
        $precinct->setConnection($request->header()['office-name'][0]);
        return $precinct->find($id);
    }        

    public function get_schedules(Request $request, $id) {
        $precinct = new Precinct;
        $precinct->setConnection($request->header()['office-name'][0]);
        $precinct = $precinct->find($id);
        return $precinct->schedules;
    }    

    public function add_schedule(Request $request, $precinct_id, $schedule_id) {
        $precinct = new Precinct;
        $precinct->setConnection($request->header()['office-name'][0]);
        $precinct = $precinct->find($id);
        $precinct->schedules()->attach($schedule_id);
    }

    public function remove_schedule(Request $request, $precinct_id, $schedule_id) {
        $precinct = new Precinct;
        $precinct->setConnection($request->header()['office-name'][0]);
        $precinct = $precinct->find($id);
        $precinct->schedules()->detach($schedule_id);
    }
}

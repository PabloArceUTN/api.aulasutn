<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Period;

use App\Http\Requests;

class PeriodController extends Controller
{
    public function index(Request $request) {
        $period = new Period;
        $period->setConnection($request->header()['office-name'][0]);
        return $period->all();
    }

    public function store(Request $request) {
        $period = new Period;
        $period->setConnection($request->header()['office-name'][0]);
        $period['attributes'] = $request->all();
        try {
            if($period->save()) {
                return Response::json(array(
                    "status" => 201,
                    "message" => "A new period has been created!",
                    "period" => $period
                ), 201);
            } else {
                throw new Exception('Error processing request!');
            }
        } catch(QueryException $e) {
            return Response::json(array(
                    "status" => 406,
                    "message" => $e->getMessage(),
                    "period" => $period,
            ), 406);
        }
    }

    public function update(Request $request, $id) {
        $period = new Period;
        $period->setConnection($request->header()['office-name'][0]);
        $period = $period->find($id);
        if(sizeof($period)) {
            $period->fill($request->all());
            try {
                if($period->save()) {
                      return Response::json(array(
                          "status" => 200,
                          "message" => "A period has been updated successfully!",
                          "period" => $period
                        ), 200);
                } else {
                      throw new Exception("Error Processing Request");
                }
            } catch(QueryException $e) {
                return Response::json(array(
                        "status" => 406,
                        "message" => $e->getMessage(),
                        "period" => $period,
                ), 406);
            }
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Period not found!"
            ), 404);
        }
    }

    public function destroy(Request $request, $id) {
        $period = new Period;
        $period->setConnection($request->header()['office-name'][0]);
        $period = $period->find($id);
        if(sizeof($period)) {
            $period->delete();
            return Response::json(array(
                          "status" => 200,
                          "message" => "An period has been deleted successfully!",
                          "period" => $period
                        ), 200);
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "period not found!"
            ), 404);
        }
    }
}

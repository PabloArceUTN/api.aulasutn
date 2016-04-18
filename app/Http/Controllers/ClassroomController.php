<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Classroom;

use App\Http\Requests;

class ClassroomController extends Controller
{
    protected $connection = 'san_carlos';

    public function __construct(Request $request)
    {
      //Call for token authentication before execute the rest of the controller
      Parent::InitAuth($request);
    }

    public function index() {
        $classroom = new Classroom;
        $classroom->setConnection($request->header()['office-name'][0]);
        return $classroom->all();
    }

    public function store(Request $request) {
        $classroom = new Classroom;
        $classroom->setConnection($request->header()['office-name'][0]);
        $classroom['attributes'] = $request->except(['remember', 'token']);
        try {
            if($classroom->save()) {
                return Response::json(array(
                    "status" => 201,
                    "message" => "A new classroom has been created!",
                    "classroom" => $classroom,
                ), 201);
            } else {
                throw new Exception('Error processing request!');
            }
        } catch(QueryException $e) {
            return Response::json(array(
                    "status" => 406,
                    "message" => $e->getMessage(),
                    "classroom" => $classroom,
            ), 406);
        }
    }

    public function update(Request $request, $id) {
        $classroom = new Classroom;
        $classroom->setConnection($request->header()['office-name'][0]);
        $classroom = $classroom->find($id);
        if(sizeof($classroom)) {
            $classroom->fill($request->except(['remember', 'token']));
            try {
                if($classroom->save()) {
                      return Response::json(array(
                          "status" => 200,
                          "message" => "A classroom has been updated successfully!",
                          "classroom" => $classroom
                        ), 200);
                } else {
                      throw new Exception("Error Processing Request");
                }
            } catch(QueryException $e) {
                return Response::json(array(
                        "status" => 406,
                        "message" => $e->getMessage(),
                        "classroom" => $classroom,
                ), 406);
            }
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Classroom not found!"
            ), 404);
        }
    }

    public function destroy($id) {
        $classroom = new Classroom;
        $classroom->setConnection($request->header()['office-name'][0]);
        $classroom = $classroom->find($id);
        if(sizeof($classroom)) {
            $classroom->delete();
            return Response::json(array(
                          "status" => 200,
                          "message" => "An classroom has been deleted successfully!",
                          "classroom" => $classroom
                        ), 200);
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Classroom not found!"
            ), 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Career;

use App\Http\Requests;

class CareersController extends Controller
{
    public function index() {   
        return Career::all();
    }

    public function store(Request $request) {
        $career = new Career;
        //var_dump($request->all());
        $career['attributes'] = $request->all();
        try {
            if($career->save()) {
                return Response::json(array(
                    "status" => 201,
                    "message" => "A new career has been created!",
                    "career" => $career,
                ), 201);
            } else {
                throw new Exception("Error Processing Request");
            }
        } catch(QueryException $e) {
            return Response::json(array(
                    "status" => 406,
                    "message" => $e->getMessage(),
                    "career" => $career,
            ), 406);
        }
    }

    public function update(Request $request, $id) {
        $career = Career::find($id);
        if(sizeof($career)) {
            $career->fill($request->all());
            try {
                if($career->save()) {
                    return Response::json(array(), 204);
                } else {
                    throw new Exception("Error Processing Request");
                }
            } catch(QueryException $e) {
                return Response::json(array(
                        "status" => 406,
                        "message" => $e->getMessage(),
                        "career" => $career,
                ), 406);
            }
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Career not found!"
            ), 404);
        }
    }

    public function destroy($id) {
        $career = Career::find($id);
        if(sizeof($career)) {
            $career->delete();
            return Response::json(array(), 204);
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Career not found!"
            ), 404);
        }
    }

    public function add_course($career_id, $course_id) {
        $career = Career::find($id);
        $career->courses()->attach($course_id);
    }

    public function add_user($career_id, $user_id) {
        $career = Career::find($id);
        $career->users()->attach($user_id);
    }

}

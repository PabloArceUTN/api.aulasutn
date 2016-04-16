<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Course;

use App\Http\Requests;

class CoursesController extends Controller
{
  public function __construct(Request $request)
  {
    //Call for token authentication before execute the rest of the controller
    Parent::InitAuth($request);
  }
  public function index() {
    return Course::all();
  }

  public function store(Request $request) {
    $course = new Course;
    $course['attributes'] = $request->all();
    try {
      if($course->save()) {
        return Response::json(array(
          "status" => 201,
          "message" => "A new course has been created!",
          "course" => $course,
        ), 201);
      } else {
        throw new Exception("Error Processing Request");
      }
    } catch(QueryException $e) {
      return Response::json(array(
        "status" => 406,
        "message" => $e->getMessage(),
        "course" => $course,
      ), 406);
    }
  }

  public function update(Request $request, $id) {
    $course = Course::find($id);
    if(sizeof($course)) {
      $course->fill($request->all());
      try {
        if($course->save()) {
          return Response::json(array(
            "status" => 200,
            "message" => "A course has been updated successfully!",
            "course" => $course
          ), 200);
        } else {
          throw new Exception("Error Processing Request");
        }
      } catch(QueryException $e) {
        return Response::json(array(
          "status" => 406,
          "message" => $e->getMessage(),
          "course" => $course,
        ), 406);
      }
    } else {
      return Response::json(array(
        "status" => 404,
        "message" => "Course not found!"
      ), 404);
    }
  }

  public function destroy($id) {
    $course = Course::find($id);
    if(sizeof($course)) {
      $course->delete();
      return Response::json(array(
        "status" => 200,
        "message" => "A course has been deleted successfully!",
        "course" => $course
      ), 200);
    } else {
      return Response::json(array(
        "status" => 404,
        "message" => "Course not found!"
      ), 404);
    }
  }

  public function add_career($course_id, $career_id) {
    $course = Course::find($id);
    $course->careers()->attach($career_id);
  }

  public function add_user($course_id, $user_id) {
    $course = Course::find($id);
    $course->users()->attach($user_id);
  }

  public function remove_career($course_id, $career_id) {
    $course = Course::find($id);
    $course->careers()->detach($career_id);
  }

  public function remove_user($course_id, $user_id) {
    $course = Course::find($id);
    $course->users()->detach($user_id);
  }

}

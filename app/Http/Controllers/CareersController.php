<?php
namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Career;
use App\Http\Requests;
class CareersController extends Controller
{
  public function __construct(Request $request)
  {
    //Call for token authentication before execute the rest of the controller
    Parent::InitAuth($request);
  }
  public function index() {
    return Career::all();
  }
  public function store(Request $request) {
    $career = new Career;
    $career['attributes'] = $request->except(['remember', 'token']);
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
      $career->fill($request->except(['remember', 'token']));
      try {
        if($career->save()) {
          return Response::json(array(
            "status" => 200,
            "message" => "A career has been updated successfully!",
            "career" => $career
          ), 200);
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
    public function show($id) {
        return Career::find($id);
    }
    public function get_courses($id) {
        return Career::find($id)->courses;
    }
    public function get_users($id) {
        return Career::find($id)->users;
    }
    public function add_course($career_id, $course_id) {
        $career = Career::find($career_id);
        $career->courses()->attach($course_id);
    }
  public function destroy($id) {
    $career = Career::find($id);
    if(sizeof($career)) {
      $career->delete();
      return Response::json(array(
        "status" => 200,
        "message" => "A career has been deleted successfully!",
        "career" => $career
      ), 200);
    } else {
      return Response::json(array(
        "status" => 404,
        "message" => "Career not found!"
      ), 404);
    }
  }
  public function add_user($career_id, $user_id) {
    $career = Career::find($id);
    $career->users()->attach($user_id);
  }
  public function remove_course($career_id, $course_id) {
    $career = Career::find($id);
    $career->courses()->detach($course_id);
  }
  public function remove_user($career_id, $user_id) {
    $career = Career::find($id);
    $career->users()->detach($user_id);
  }
}

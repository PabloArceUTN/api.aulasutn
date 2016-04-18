<?php
namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Office;
use App\Http\Requests;
class OfficesController extends Controller
{
  public function __construct(Request $request)
  {
    //Call for token authentication before execute the rest of the controller
    Parent::InitAuth($request);
  }
  public function index() {
    return Office::all();
  }
  public function store(Request $request) {
    $office = new Office;
    $office['attributes'] = $request->except(['remember', 'token']);
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
      $office->fill($request->except(['remember', 'token']));
      try {
        if($office->save()) {
          return Response::json(array(
            "status" => 200,
            "message" => "An office has been updated successfully!",
            "office" => $office
          ), 200);
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
    public function get_users($id) {
        return Office::find($id)->users;
    }
  public function destroy($id) {
    $office = Office::find($id);
    if(sizeof($office)) {
      $office->delete();
      return Response::json(array(
        "status" => 200,
        "message" => "An office has been deleted successfully!",
        "office" => $office
      ), 200);
    } else {
      return Response::json(array(
        "status" => 404,
        "message" => "Office not found!"
      ), 404);
    }
  }
  public function add_user($office_id, $user_id) {
    $office = Office::find($office_id);
    $office->users()->attach($user_id);
  }
  public function remove_user($office_id, $user_id) {
    $office = Office::find($office_id);
    $office->users()->detach($user_id);
  }
}

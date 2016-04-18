<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Schedule;

use App\Http\Requests;

class ScheduleController extends Controller
{
  public function __construct(Request $request)
  {
    //Call for token authentication before execute the rest of the controller
    Parent::InitAuth($request);
  }

  public function index(Request $request) {
    $schedule = new Schedule;
    $schedule->setConnection($request->header()['office-name'][0]);
    return $schedule->all();
  }

  public function store(Request $request) {
    $schedule = new Schedule;
    $schedule->setConnection($request->header()['office-name'][0]);
    $schedule['attributes'] = $request->except(['remember', 'token']);
    try {
      if($schedule->save()) {
        return Response::json(array(
          "status" => 201,
          "message" => "A new schedule has been created!",
          "schedule" => $schedule
        ), 201);
      } else {
        throw new Exception('Error processing request!');
      }
    } catch(QueryException $e) {
      return Response::json(array(
        "status" => 406,
        "message" => $e->getMessage(),
        "schedule" => $schedule,
      ), 406);
    }
  }

  public function update(Request $request, $id) {
    $schedule = new Schedule;
    $schedule->setConnection($request->header()['office-name'][0]);
    $schedule = $schedule->find($id);
    if(sizeof($schedule)) {
      $schedule->fill($request->except(['remember', 'token']));
      try {
        if($schedule->save()) {
          return Response::json(array(
            "status" => 200,
            "message" => "A schedule has been updated successfully!",
            "schedule" => $schedule
          ), 200);
        } else {
          throw new Exception("Error Processing Request");
        }
      } catch(QueryException $e) {
        return Response::json(array(
          "status" => 406,
          "message" => $e->getMessage(),
          "schedule" => $schedule,
        ), 406);
      }
    } else {
      return Response::json(array(
        "status" => 404,
        "message" => "Schedule not found!"
      ), 404);
    }
  }

    public function show(Request $request, $id) {
        $schedule = new Schedule;
        $schedule->setConnection($request->header()['office-name'][0]);
        return $schedule->find($id);
    }

    public function get_precincts(Request $request, $id) {
        $schedule = new Schedule;
        $schedule->setConnection($request->header()['office-name'][0]);
        return $schedule->find($id)->precincts;
    }

   public function add_precinct(Request $request, $schedule_id, $precinct_id) {
        $schedule = new Schedule;
        $schedule->setConnection($request->header()['office-name'][0]);
        $schedule = $schedule->find($id);
        $schedule->precincts()->attach($precinct_id);
    }

    public function remove_precinct(Request $request, $schedule_id, $precinct_id) {
        $schedule = new Schedule;
        $schedule->setConnection($request->header()['office-name'][0]);
        $schedule = $schedule->find($id);
        $schedule->precincts()->detach($precinct_id);
    }

  public function destroy(Request $request, $id) {
    $schedule = new Schedule;
    $schedule->setConnection($request->header()['office-name'][0]);
    $schedule = $schedule->find($id);
    if(sizeof($schedule)) {
      $schedule->delete();
      return Response::json(array(
        "status" => 200,
        "message" => "An schedule has been deleted successfully!",
        "schedule" => $schedule
      ), 200);
    } else {
      return Response::json(array(
        "status" => 404,
        "message" => "Schedule not found!"
      ), 404);
    }
  }

  public function add_precinct(Request $request, $schedule_id, $precinct_id) {
    $schedule = new Schedule;
    $schedule->setConnection($request->header()['office-name'][0]);
    $schedule = $precinct->find($id);
    $schedule->precincts()->attach($precinct_id);
  }
}

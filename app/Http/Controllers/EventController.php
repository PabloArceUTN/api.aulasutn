<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Event;

use App\Http\Requests;

class EventController extends Controller
{
    protected $connection = 'central';

    public function index() {
        $event = new Event;
        $event->setConnection($request->header()['office-name'][0]);
        return $event->all();
    }

    public function store(Request $request) {
        $event = new Event;
        $event->setConnection($request->header()['office-name'][0]);
        $event['attributes'] = $request->all();
        try {
            if($event->save()) {
                return Response::json(array(
                    "status" => 201,
                    "message" => "A new event has been created!",
                    "event" => $event,
                ), 201);
            } else {
                throw new Exception('Error processing request!');
            }
        } catch(QueryException $e) {
            return Response::json(array(
                    "status" => 406,
                    "message" => $e->getMessage(),
                    "event" => $event,
            ), 406);
        }
    }

    public function update(Request $request, $id) {
        $event = new Event;
        $event->setConnection($request->header()['office-name'][0]);
        $event = $event->find($id);
        if(sizeof($event)) {
            $event->fill($request->all());
            try {
                if($event->save()) {
                      return Response::json(array(
                          "status" => 200,
                          "message" => "A event has been updated successfully!",
                          "event" => $event
                        ), 200);
                } else {
                      throw new Exception("Error Processing Request");
                }
            } catch(QueryException $e) {
                return Response::json(array(
                        "status" => 406,
                        "message" => $e->getMessage(),
                        "event" => $event,
                ), 406);
            }
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Event not found!"
            ), 404);
        }
    }

    public function destroy($id) {
        $event = new Event;
        $event->setConnection($request->header()['office-name'][0]);
        $event = $event->find($id);
        if(sizeof($event)) {
            $event->delete();
            return Response::json(array(
                          "status" => 200,
                          "message" => "An event has been deleted successfully!",
                          "event" => $event
                        ), 200);
        } else {
            return Response::json(array(
                "status" => 404,
                "message" => "Event not found!"
            ), 404);
        }
    }
}

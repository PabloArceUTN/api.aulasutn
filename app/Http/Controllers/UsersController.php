<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Illuminate\Database\QueryException;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Users;
use App\Http\Models\Office;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
	/**
     * Returns all the users that has been created.
     */
    public function index()
    {
    	return Users::all();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       	$user = new Users;
       	$user['attributes'] = $request->all();
       	try {
       		if($user->save()) {
           		return Response::json(array(
           			"status" => 201,
               		"message" => "A new user has been created!",
               		"user" => $user,
           		), 201);
       		} else {
           		throw new Exception("Error Processing Request");
       		}
       	} catch(QueryException $e) {
       		return Response::json(array(
           			"status" => 406,
               		"message" => $e->getMessage(),
               		"user" => $user,
           	), 406);
       	}
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Users::find($id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$user = Users::find($id);
    	if(sizeof($user)) {
    		$user->fill($request->all());
    		try {
       			if($user->save()) {
           			  return Response::json(array(
                          "status" => 200,
                          "message" => "A user has been updated successfully!",
                          "user" => $user
                        ), 200);
       			} else {
           			  throw new Exception("Error Processing Request");
       			}
       		} catch(QueryException $e) {
       			return Response::json(array(
           				"status" => 406,
               			"message" => $e->getMessage(),
               			"user" => $user,
           		), 406);
       		}
    	} else {
    		return Response::json(array(
        		"status" => 404,
           		"message" => "User not found!"
        	), 404);
    	}
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$before = Users::find($id);
    	if(sizeof($before)) {
    		$before->active = false;
    		$before->save();
        	return Response::json(array(
                          "status" => 200,
                          "message" => "A user has been disabled successfully!",
                          "user" => $before
                      ), 200);
    	} else {
    		return Response::json(array(
           		"status" => 404,
            	"message" => "User not found!"
        	), 404);
    	}
    }

    public function add_office($user_id, $office_id) {
      $user = Users::find($user_id);
      $user->offices()->attach($office_id);
    }

    public function add_career($user_id, $career_id) {
      $user = Users::find($user_id);
      $user->careers()->attach($career_id);
    }

    public function add_course($user_id, $course_id) {
      $user = Users::find($user_id);
      $user->courses()->attach($course_id);
    }

    public function remove_office($user_id, $office_id) {
      $user = Users::find($user_id);
      $user->offices()->detach($office_id);
    }

    public function remove_career($user_id, $career_id) {
      $user = Users::find($user_id);
      $user->careers()->detach($career_id);
    }

    public function remove_course($user_id, $course_id) {
      $user = Users::find($user_id);
      $user->courses()->detach($course_id);
    }

}

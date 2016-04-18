<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

class SessionController extends Controller
{

  public function __construct(Request $request)
  {
    //Call for token authentication before execute the rest of the controller
    Parent::InitAuth($request);
  }

  public function index()
  {
    # code...
  }

  // This destroy the user session
  public function LogOut(Request $request)
  {
    try {
      $dots = str_replace('.', '', $request->input('token'));
      echo $dots;
      var_dump(Session::all());
      if (Session::has($dots)) {
        Session::forget($dots);
        return response()->json(['message' => 'logout'], 200);
      }else {
        return response()->json(['message' => 'session_not_exist'], 200);
      }
    } catch (Exception $e) {
      return response()->json(['error' => '$e'], 422);
    }
  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;
use App\Http\Models\Session as SM;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected function InitAuth(Request $request)
  {
    $dots = str_replace('.', '', $request->input('token'));
    if (!Session::has($dots) && $request->input('remember')=="true") {
      // In case of the condition was true, look into the database that token
      if ($session = SM::where('token', $request->input('token'))->where('expires', '>', \Carbon\Carbon::now())->get()->first()) {
        //Insert the token into the
        Session::put($dots, $session->token);
      }else {
        // Access denied!
        return response()->json(['error' => 'invalid_credentials, login_again'], 401);
      }
    }else {
      if (!Session::has($dots)) {
        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
      }
    }
  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Models\Users;
use App\Http\Models\Session as SM;
use Session;
use Carbon\Carbon;

class AuthenticateController extends Controller
{
  public function authenticate(Request $request)
  {
    $credentials = $request->only('email', 'password');

    try {
      // verify the credentials and create a token for the user
      if (! $acces = JWTAuth::attempt($credentials)) {
        return response()->json(['error' => 'invalid_credentials'], 401);
      }
    } catch (JWTException $e) {
      // something went wrong
      return response()->json(['error' => 'could_not_create_token'], 500);
    }
    $user = Users::where('email', $request->input('email'))->where('active', true)
    ->get()->first();
    // if no errors are encountered we can return a JWT
    // if (!\Hash::check($request->input('password'), $user->password)) {
    //   return response()->json(['error' => 'could_not_create_token'], 500);
    // }
    $customClaims = ['keytime' => Carbon::now(), 'letpass'=> $user->password, 'credentials'=> $credentials];
    $token = JWTAuth::fromUser($user, $customClaims);
    // if the user want to remember the session, it could store the token in DB
    // and create a session key
    if ($request->input('remember')=="true") {
      $session = new SM;
      $session->token = $token;
      $session->expires = Carbon::now()->addWeek(6);
      $session->active = true;
      $session->save();
      $user->sessions()->attach($session->id);
      Session::put(str_replace('.', '', $session->token), $session->token);
      return response()->json(['message' => $session->token, 'admin' => $user->admin], 200);
    }
    return response()->json(['token' => $token,'admin' => $user->admin], 200);
  }
}

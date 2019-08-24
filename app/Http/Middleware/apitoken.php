<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Contracts\Auth\Guard;

class apitoken
{
    protected $auth;
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->input('api_token') && $this->hasMatchingToken($request->input('api_token') ) ) {
            return $next($request);
        }
        else {
          if ($request->ajax()) {
              return response('Unauthorized.', 401);
          } else {
              return redirect()->guest('login');
          }
        }
        return $next($request);
    }

    public function hasMatchingToken($token)
    {
        //dd(User::where('api_token', $token)->first()->nama);
        if($user = User::where('api_token', $token)->first()){
          return true;
        }
    }
}

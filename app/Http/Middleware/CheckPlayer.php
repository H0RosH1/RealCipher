<?php

namespace App\Http\Middleware;

use App\Models\Players;
use Closure;
use Illuminate\Http\Request;

class CheckPlayer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('uid')){
            $uid = session('uid');
            if($player = Players::where('uid',$uid)->first()){
                return $next($request);
            }
            return redirect(route('home'));
        }
        return redirect(route('home'));
    }
}

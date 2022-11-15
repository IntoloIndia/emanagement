<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BillingAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->has('BILLING_LOGIN'))
        {
            // return redirect('/'. $path);
        }else{
            $request->session()->flash('msg','Access denied');
            return redirect('/');
        }
        return $next($request);
    }
}

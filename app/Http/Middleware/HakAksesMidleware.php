<?php

namespace App\Http\Middleware;

use Closure;

class HakAksesMidleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$namaRule,$namaRule2)
    {
        if (auth()->check() && !auth()->user()->punyaRule($namaRule,$namaRule2)) {
          return redirect('/')->withErrors(['Anda tak punya akses untuk mengakses halaman!']);
        }
        return $next($request);
    }
}

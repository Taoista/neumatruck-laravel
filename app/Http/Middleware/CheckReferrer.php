<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckReferrer
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
         // Verificar el referrer
         $referrer = $request->headers->get('referer');

         if (strpos($referrer, 'marlon-uxui.cl') !== false) {
             // Si el referrer coincide, redirigir a una ruta específica con el mensaje
             return response()->view('referrer-message');
         }
 
         return $next($request);
    }
}

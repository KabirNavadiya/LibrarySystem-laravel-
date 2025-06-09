<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateBookInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->isMethod('post')){
            $validate = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'is_available' => 'required|boolean'
            ]);
        }
        return $next($request);
    }
}

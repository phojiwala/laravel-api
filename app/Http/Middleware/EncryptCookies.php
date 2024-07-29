<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EncryptCookies
{
  protected $except = [
    // List of cookies that should not be encrypted
  ];

  public function handle(Request $request, Closure $next)
  {
    $response = $next($request);

    if ($response instanceof Response) {
      $response->header('Content-Type', 'application/json');
    }

    return $response;
  }
}

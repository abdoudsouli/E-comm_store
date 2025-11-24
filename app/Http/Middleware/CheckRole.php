<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
        if (empty($role)) {
            return response()->json(['message' => 'No role specified in middleware.'], 500);
        }
        $staff_account = $request->user();
        if ($staff_account->role->role_name !== $role) {
            return response()->json([
            'message'=>"Access denied. can access this resources.",
            ],401);
         }
        return $next($request);
    }
}

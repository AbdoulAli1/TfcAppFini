<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPromotion
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
        $etudiant = Auth::guard('etudiant')->user();

        if ($etudiant && in_array($etudiant->promotion, ['L1', 'L2'])) {
            return redirect()->route('travail.consulterParFiliere')
                ->with('error', 'Les étudiants de L1 et L2 ne peuvent pas déposer un TFC.');
        }

        return $next($request);
    }
}

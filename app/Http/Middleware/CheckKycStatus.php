<?php

namespace App\Http\Middleware;

use App\Enums\KycStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckKycStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('web')->user();
        if($user->kyc->status == KycStatus::Pending || $user->kyc->status == KycStatus::Approved || $user->kyc?->status == null) {
            return redirect(route('vendor.dashboard'));
        }else {
            return $next($request);
        }
    }
}

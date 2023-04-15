<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use App\Exceptions\UserException;
use Illuminate\Cache\RateLimiter;

class RequestLimitMiddleware
{
    public function handle($request, Closure $next, $rate, $time)
    {
        $rateLimiter = app(RateLimiter::class);
        $maxRequests = max(1, (int)$rate);
        $timeWindow = max(1, (int)$time);

        $maxRequestsPerMinute = $maxRequests / $timeWindow;

        $identifier = 'login:' . $request->input('email');

        $isRateLimited = $rateLimiter->tooManyAttempts($identifier, $maxRequestsPerMinute);
        if ($isRateLimited) {
            $remainingSeconds = $rateLimiter->availableIn($identifier); // Get time remaining in seconds
            $remainingMinutes = floor($remainingSeconds / 60);
            $remainingSeconds %= 60;
            UserException::throw("Terlalu Banyak Request, Coba lagi dalam {$remainingMinutes} menit {$remainingSeconds} detik", 429, 429);
            echo 'gagla';
        }

        $rateLimiter->hit($identifier, $timeWindow * 60);

        return $next($request);
    }
}

<?php

namespace Ysfkaya\NovaFeedback\Http\Middleware;

use Ysfkaya\NovaFeedback\NovaFeedback;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(NovaFeedback::class)->authorize($request) ? $next($request) : abort(403);
    }
}

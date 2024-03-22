<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\MessageCapsule;
use Carbon\Carbon;

class CheckScheduledOpeningTime
{
    public function handle($request, Closure $next)
    {
        $messageCapsuleId = $request->route('id');
        $messageCapsule = MessageCapsule::find($messageCapsuleId);
        
        if ($messageCapsule && !$messageCapsule->opened && $messageCapsule->scheduled_opening_time > Carbon::now()) {
            return response()->json(['error' => 'Message capsule is not yet open.'], 403);
        }
        
        return $next($request);
    }
}

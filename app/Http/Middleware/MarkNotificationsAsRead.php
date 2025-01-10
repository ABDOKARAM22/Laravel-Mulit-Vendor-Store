<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarkNotificationsAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $notification_id = $request->query('notification_id');

        if($notification_id){

            $user = $request->user();

            if($user){

              $notification = $user->unreadnotifications()->find($notification_id);

                if($notification){

                    $notification->MarkAsRead();

                }
            }
        }
        
        return $next($request);
    }
}

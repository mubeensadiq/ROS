<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PushSubscription;
use App\Models\User;
use App\Notifications\NewOrder;
use Illuminate\Support\Facades\Log;

class PushNotificationsController extends Controller
{
    
    /**
     *
     * Create user's desktop push notification
     *
     * @param    id, object  request
     * @return   status
     *
     */
    public function newOrder($title, $body)
    {
        try {
            $users = User::get();
            foreach($users as $user){
              $notification =  PushSubscription::where('subscribable_id' , $user->id)->first();
              if($notification)
                $user->notify(new \App\Notifications\NewOrder($title, $body));
            }
            
            return response()->json(['success' => true]);
        } catch(\Exception $e) {
        }
    }
    
    public function enableNotifications(Request $request)
    {
        try {
            $pushTitle = 'Welcome';
            $user = User::findOrFail(auth()->user()->id);
            $notification = PushSubscription::where('subscribable_id', $user->id)->where('endpoint', $request->input('endpoint'))->first();
            if (!$notification) {
                $user->updatePushSubscription($request->input('endpoint'), $request->input('keys.p256dh'), $request->input('keys.auth'));
                $user->notify(new NewOrder($pushTitle, "You will now get all notifications for new order", []));
            } else {
                $user->notify(new NewOrder("Push Notification", "You have already enabled notifications for this browser", []));
            }
            return response()->json(['success' => true]);
        } catch(\Exception $ex) {
            Log::info($ex);
        }
    }
    public function disableNotification(Request $request)
    {
        try {
            $user = auth()->user();
            $notification = PushSubscription::where('user_id', $user->id)->where('endpoint', $request->input('endpoint'))->first();
            if ($notification) {
                $notification->delete();
            }
            return response()->json(['success' => true]);
        } catch(\Exception $ex) {
            Log::info("saveFirebaseToken");
            Log::info($ex);
        }
    }
}

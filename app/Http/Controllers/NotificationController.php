<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function show(DatabaseNotification $notification)
    {
        // dd($notification);
        try {
            $model = (new $notification->data['referensi_type'])->findOrFail($notification->data['referensi_id']);
            if (isset($notification->data['priority']) && $notification->data['priority'] != 1) {
                $notification->read_at = now();
                $notification->save();
            }
            return redirect($model->routeNotification(priority: $notification->data['priority']));
        } catch (\Throwable $th) {
            return abort(403);
        }
    }
}

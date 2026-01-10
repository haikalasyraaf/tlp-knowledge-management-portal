<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $type = $notification->data['type'] ?? null;

        $routes = [
            'Training Request' => 'training-request.index',
            'Transfer of Knowledge' => 'transfer-of-knowledge.index',
            'Internal Bulletin' => 'internal-bulletin.index',
        ];

        return redirect()->route($routes[$type] ?? 'dashboard');
    }
}

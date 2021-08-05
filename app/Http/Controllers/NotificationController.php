<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('JWT');
    }

    public function index()
    {
        return [
            'readNotifications' => NotificationResource::collection(auth()->user()->readNotifications),
            'unreadNotifications' => NotificationResource::collection(auth()->user()->unreadNotifications)
        ];
    }

    public function markAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->where('id', $request->id)->markAsRead();

        return ['id' => $request->id];
    }
}

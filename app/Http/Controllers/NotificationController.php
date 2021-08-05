<?php

namespace App\Http\Controllers;

use App\Interfaces\Resources\NotificationRepositoryInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->middleware('JWT');

        $this->notificationRepository = $notificationRepository;

    }

    public function index()
    {
        $readNotifications = auth()->user()->readNotifications;
        $unreadNotifications = auth()->user()->unreadNotifications;

        return [
            'readNotifications' => $this->notificationRepository->index($readNotifications),
            'unreadNotifications' => $this->notificationRepository->index($unreadNotifications)
        ];
    }

    public function markAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->where('id', $request->id)->markAsRead();

        return ['id' => $request->id];
    }
}

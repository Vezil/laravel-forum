<?php

namespace App\Repositories;

use App\Interfaces\Resources\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{

    public function index($notifications)
    {

        $formattedNotifications = collect($notifications)->transform(function ($notification) {
            return $this->toArray($notification);
        });

        return $formattedNotifications;
    }

    public function toArray($notification)
    {
        return [
            'id' => $notification->id,
            'replyBy' => $notification->data['replyBy'],
            'question' => $notification->data['question'],
            'path' => $notification->data['path']
        ];
    }
}

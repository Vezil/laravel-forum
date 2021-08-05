<?php

namespace App\Interfaces\Resources;

interface NotificationRepositoryInterface
{
    public function index($notifications);

    public function toArray($notification);
}

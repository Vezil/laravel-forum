<?php

namespace App\Interfaces\Resources;

interface ReplyRepositoryInterface
{
    public function index($replies);

    public function show($reply);

    public function toArray($reply);
}

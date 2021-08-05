<?php

namespace App\Repositories;

use App\Interfaces\Resources\ReplyRepositoryInterface;

class ReplyRepository implements ReplyRepositoryInterface
{

    public function index($replies)
    {
        $replies->getCollection()->transform(function ($reply) {
            return $this->toArray($reply);
        });

        return $replies;
    }

    public function show($reply)
    {
        return $this->toArray($reply);
    }

    public function toArray($reply)
    {
        return [
            'id' => $reply->id,
            'reply' => $reply->body,
            'question_slug' => $reply->question->slug,
            'liked' => !!$reply->like->where('user_id', auth()->id())->count(),
            'like_count' => $reply->like->count(),
            'user' => $reply->user->name,
            'user_id' => $reply->user_id,
            'created_at' => $reply->created_at->diffForHumans()
        ];
    }
}

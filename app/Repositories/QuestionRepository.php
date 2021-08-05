<?php

namespace App\Repositories;

use App\Interfaces\Resources\QuestionRepositoryInterface;
use App\Models\Question;

class QuestionRepository implements QuestionRepositoryInterface
{
    public function index()
    {
        $questions = Question::latest()->paginate(10);

        $questions->getCollection()->transform(function ($question) {
            return $this->toArray($question);
        });

        return $questions;
    }

    public function show($question)
    {
        return $this->toArray($question);
    }

    public function toArray($question)
    {
        return [
            'id' => $question->id,
            'title' => $question->title,
            'slug' => $question->slug,
            'path' => $question->path,
            'body' => $question->body,
            'created_at' => $question->created_at->diffForHumans(),
            'user' => $question->user->name,
            'user_id' => $question->user_id,
            'replies' => $question->replies->map(function ($reply) {
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
            }),
            'replies_count' => $question->replies->count()
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\CreateEditReplyEvent;
use App\Events\DeleteReplyEvent;
use App\Interfaces\Resources\ReplyRepositoryInterface;
use App\Models\Question;
use App\Models\Reply;
use App\Notifications\NewReplyNotification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{
    public function __construct(ReplyRepositoryInterface $replyRepository)
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);

        $this->replyRepository = $replyRepository;
    }

    public function index(Question $question)
    {
        return $this->replyRepository->index($question->replies);
    }

    public function store(Question $question, Request $request)
    {
        $reply = $question->replies()->create($request->all());
        $user = $question->user;

        if ($reply->user_id !== $question->user_id) {
            $replyNotification = new NewReplyNotification($reply, $this->replyRepository);

            $user->notify($replyNotification);
        }

        $formattedReply = $this->replyRepository->toArray($reply);

        $createReplyEvent = new CreateEditReplyEvent($formattedReply, $question->id, 'create');

        broadcast($createReplyEvent)->toOthers();

        return response(['reply' => $formattedReply], Response::HTTP_CREATED);
    }

    public function show(Question $question, Reply $reply)
    {
        return $this->replyRepository->show($reply);
    }

    public function update(Question $question, Request $request, Reply $reply)
    {
        $reply->update($request->all());

        $formattedReply = $this->replyRepository->toArray($reply);

        $editReplyEvent = new CreateEditReplyEvent($formattedReply, $question->id, 'update');

        broadcast($editReplyEvent)->toOthers();

        return response(['reply' => $formattedReply], Response::HTTP_OK);
    }

    public function destroy(Question $question, Reply $reply)
    {
        $reply->delete();

        $deleteReplyEvent = new DeleteReplyEvent($reply->id, $reply->question_id);

        broadcast($deleteReplyEvent)->toOthers();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

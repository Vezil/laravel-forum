<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Interfaces\Resources\QuestionRepositoryInterface;
use App\Models\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->middleware('JWT', ['except' => ['index']]);

        $this->questionRepository = $questionRepository;
    }

    public function index()
    {
        return $this->questionRepository->index();
    }

    public function store(QuestionRequest $request)
    {
        $question = auth()->user()->questions()->create($request->all());

        $formattedQuestion = $this->questionRepository->toArray($question);

        return response($formattedQuestion, Response::HTTP_CREATED);
    }

    public function show(Question $question)
    {
        return $this->questionRepository->show($question);
    }

    public function update(Request $request, Question $question)
    {
        $question->update($request->all());

        return response(['question' => $question], Response::HTTP_ACCEPTED);
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

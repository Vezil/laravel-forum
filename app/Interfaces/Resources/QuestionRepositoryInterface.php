<?php

namespace App\Interfaces\Resources;

interface QuestionRepositoryInterface
{
    public function index();

    public function show($question);

    public function toArray($question);
}

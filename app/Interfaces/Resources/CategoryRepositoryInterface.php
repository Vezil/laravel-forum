<?php

namespace App\Interfaces\Resources;

interface CategoryRepositoryInterface
{
    public function index();

    public function show($category);

    public function toArray($category);
}

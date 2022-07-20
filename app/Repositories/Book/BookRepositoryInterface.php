<?php

namespace App\Repositories\Book;

Interface BookRepositoryInterface
{
    public function getAllBooks($request);

    public function create($request);

    public function postReview($book, $request);
}
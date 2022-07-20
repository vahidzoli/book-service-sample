<?php

namespace App\Repositories\Book;

Interface BookRepositoryInterface
{
    public function getAllBooks();

    public function create($request);

    public function postReview($book, $request);
}
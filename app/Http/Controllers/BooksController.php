<?php

declare (strict_types=1);

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use App\Repositories\Book\BookRepositoryInterface;
use App\Http\Requests\PostBookRequest;
use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookReviewResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{
    private $bookRepository;

    public function __construct(BookRepositoryInterface $book)
    {
        $this->bookRepository = $book;
    }

    public function getCollection()
    {
        $books = $this->bookRepository->getAllBooks();

        return response()->json(new BookCollection($books), Response::HTTP_OK);
    }

    public function post(PostBookRequest $request)
    {
        $book = $this->bookRepository->create($request->all());

        return response()->json(new BookResource($book), Response::HTTP_CREATED);
    }

    public function postReview(Book $book, PostBookReviewRequest $request)
    {
        $review = $this->bookRepository->postReview($book, $request->all());

        return response()->json(new BookReviewResource($review), Response::HTTP_CREATED);
    }
}

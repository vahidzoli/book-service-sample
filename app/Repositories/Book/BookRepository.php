<?php

namespace App\Repositories\Book;

use App\Book;
use Illuminate\Support\Facades\Auth;

class BookRepository implements BookRepositoryInterface
{
    protected $bookModel;

    public function __construct(Book $book)
    {
        $this->bookModel = $book;
    }

    public function getAllBooks()
    {
        return $this->bookModel->paginate(5);
    }

    public function create($request)
    {
        $book = $this->bookModel->create($request);
        $book->save();
        $book->authors()->attach($request['authors']);

        return $book;
    }

    public function postReview($book, $request)
    {
        return $book->reviews()->create([
            'review'    => $request['review'],
            'comment'   => $request['comment'],
            'user_id'   => Auth::user()->id
        ]);
    }
}
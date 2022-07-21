<?php

namespace App\Repositories\Book;

use App\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookRepository implements BookRepositoryInterface
{
    protected $bookModel;

    public function __construct(Book $book)
    {
        $this->bookModel = $book;
    }

    public function getAllBooks($request)
    {
        return $this->filter($request);
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

    public function filter($request)
    {
        $books = (new Book)->newQuery();

        if (request()->has('title')) {
            $books->where('title', 'Like', '%' . request()->input('title') . '%');
        }

        if (request()->has('authors')) {
            $authors = explode(",", request()->input('authors'));
            
            $books->whereHas('authors', function($q) use($authors){
                $q->whereIn('authors.id', $authors);
            });
        }

        if (isset($request->sortColumn)) {
            $direction = isset($request->sortDirection) ? $request->sortDirection : 'ASC';
            $books->orderBy($request->sortColumn, $direction);

            if($request->sortColumn == 'avg_review') {
                $books->withCount(['reviews as avg_review' => function($query) {
                    $query->select(DB::raw('coalesce(avg(review),0)'));
                }])->orderBy('avg_review', $direction);
            };
        }

        $books = $books->paginate(15, ['*'], 'page', $request->get('page'));

        return $books;
    }
}
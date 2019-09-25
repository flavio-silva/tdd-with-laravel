<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store()
    {
        Book::query()->create($this->validateRequest());
    }

    public function update(Book $book)
    {
        $book->update($this->validateRequest());
    }

    private function validateRequest()
    {
        $data = request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
        return $data;
    }
}

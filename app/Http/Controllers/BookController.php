<?php

namespace App\Http\Controllers;

use App\Book;
use App\Repositories\BookRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BookController extends Controller
{

    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function index(){
        return $this->bookRepository->all();
    }

    public function findByTitle(string $title)
    {
        $this->bookRepository->findByTitle($title);
    }


    public function store(Request $request) {
        $this->bookRepository->saveBook($request);
    }

    public function update(Request $request, int $id) 
    {
        $this->bookRepository->upadeBook($request, $id);
    }

    public function destroy(int $id) {
        $this->bookRepository->deleteBook($id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Book;
use App\Repositories\BookRepository;
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
        return $this->bookRepository->findByTitle($title);
    }

    public function findById(int $id) {
        return $this->bookRepository->getById($id);
    }

    public function getBookPerCat(string $category) {
        return $this->bookRepository->bookPerCategory($category);
    }


    public function store(Request $request) {
        return $this->bookRepository->saveBook($request);
    }

    public function update(Request $request, int $id)
    {
        return $this->bookRepository->upadeBook($request, $id);
    }

    public function destroy(int $id) {
        return $this->bookRepository->deleteBook($id);
    }
}

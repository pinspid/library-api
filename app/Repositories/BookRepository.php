<?php
namespace App\Repositories;

use App\Book;
use App\Http\Resources\Book as ResourcesBook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookRepository {

    public function all() {
        $books =  Book::orderBy('title')->get();

        return ResourcesBook::collection($books);
    }

    public function findByTitle(string $title) {
        $book = Book::where('title', 'like','%' . $title . '%');
        return new ResourcesBook($book);
    }

    public function saveBook(Request $request): JsonResponse {
        
        $book = $this->validator($request);

        Book::create([...$book, 'available_copy' => $request->get('num_copy')]);

        return response()->json(['success' => 'book save successfuly']);
    }

    public function upadeBook(Request $request,int $id)
    {
        $book = Book::where('id', $id)->firstOrFail($id);

        $book->updade($this->validator($request));
     
        return response()->json(['success' => 'book updated successfuly']);
        
    }

    public function deleteBook(int $id) 
    {
        $book = Book::where('id', $id)->firstOrFail();
        $book->delete();

        return response()->json(['success' => 'book delete successfuly']);
    }

    public function bookPerCategory(string $category){
        return Book::where('category_id', $category)->get();
    }

    private function validator(Request $request)
    {
        return $request->validate([
            'title' => 'required|string',
            'edition' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'year_publish' => 'required|year',
            'num_copy' => 'required|integer'
        ]);
    }

}

<?php
namespace App\Repositories;

use App\Book;
use App\Category;
use App\Http\Resources\Book as ResourcesBook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookRepository {


    public function all() {
        //$books =  Book::orderBy('title')->get();
        return ResourcesBook::collection(Book::paginate());
    }

    public function findByTitle(string $title) {
        $book = Book::where('title', 'like','%' . $title . '%')->get();
        
        return ResourcesBook::collection($book);
    }

    public function saveBook(Request $request): JsonResponse {
        
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $book = Book::create($request->all()); 
            $book->update(['available_copy' => $book->num_copy]);  
        }

        return response()->json(['success' => 'book save successfuly']);
    }

    public function upadeBook(Request $request,int $id)
    {
        $book = Book::where('id', $id)->firstOrFail();

        $validator = $this->validator($request);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $book->update($request->all());
     
        return response()->json(['success' => 'book updated successfuly']);
        
    }

    public function deleteBook(int $id) 
    {
        $book = Book::where('id', $id)->firstOrFail();
        
        $book->delete();

        return response()->json(['success' => 'book delete successfuly']);
    }

    public function bookPerCategory(string $category){
        $category = Category::where('wording', $category)->firstOrFail();
        $arr = array();
        foreach($category->books as $book){
            array_push($arr, $book);
        }

        dd($category->books);
        return $category->books;
    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(),[
            'title' => 'required|string|unique:books',
            'category_id' => 'required|integer',
            'edition' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'year_publish' => 'required|integer',
            'num_copy' => 'required|integer'
        ]);
    }

}

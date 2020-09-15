<?php

namespace App\Repositories;

use App\Borrower;
use Illuminate\Http\Request;
use App\Http\Resources\Borrower as ResourcesBorrower;
use Illuminate\Support\Facades\Validator;

class BorrowerRepository {

    private $borrower;

    public function __construct(Borrower $borrower)
    {
        $this->borrower = $borrower;
    }

    public function all() {
        $borrowers = $this->borrower->newQuery()->orderBy('last_name')->get();
        return ResourcesBorrower::collection($borrowers);
    }

    public function findById(int $id) {
        $borrower = $this->borrower
                        ->newQuery()
                        ->findOrFail($id);
        return new ResourcesBorrower($borrower);
    }

    public function getLoanBook(int $id)
    {
        $data = $this->borrower
                        ->newQuery()
                        ->findOrFail($id)
                        ->books;
        $books = [];
        foreach($data as $book) {
            array_push($books, $book);
        }
        return $book;
    }

    public function findByName(string $name) {
        $borrowers = Borrower::where('last_name', 'like', '%' . $name . '%')
        ->orWhere(
            'first_name', 'like', '%' . $name . '%'
        )->orderBy('last_name')->get();
        return ResourcesBorrower::collection($borrowers);
    }

    public function saveBorrower(Request $request) {
        $validator = $this->validation($request);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()]);
        }

        Borrower::create($request->all());

        return response()->json(['success' => 'New Borrower has been add']);
    }

    public function updateBorrower(Request $request, int $id){

        $borrower = Borrower::where('id', $id)->firstOrFail();

        $validator = $this->validation($request);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()]);
        } else {
            $borrower->update($request->all());
            
            return response()->json(['success' => 'Borrower has been update']);
        }
    }

    public function deleteBorrower(int $id) {

        $borrower = Borrower::findOrFail($id);

        $borrower->delete();

        return response()->json(['success' => 'Borrower has been deleted']);
    }

    private function validation(Request $request) {
        return Validator::make($request->all(), [
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'email' => 'required|email|unique:borrowers',
            'phone' => 'required|integer|unique:borrowers',
            'adresse' => 'required|string'
        ]);
    }

}

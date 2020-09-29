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
        return $this->borrower
                        ->newQuery()
                        ->findOrFail($id);
    }

    public function getLoanBook(int $id)
    {
        $borrower = $this->findById($id);
        return response()->json([
            'borrower' => $borrower,
            'loan_number' => $borrower->books->count()
        ]);
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

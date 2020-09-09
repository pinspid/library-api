<?php

namespace App\Repositories;

use App\Borrower;
use Illuminate\Http\Request;
use App\Http\Resources\Borrower as ResourcesBorrower;

class BorrowerRepository {

    private $borrower;

    public function __construct(Borrower $borrower)
    {
        $this->borrower = $borrower;
    }

    public function all() {
        $borrower = $this->borrower->newQuery()->orderBy('last_name')->get();
        return ResourcesBorrower::collection($borrower);
    }

    public function findById(int $id) {
        $borrower = $this->borrower
                        ->newQuery()
                        ->findOrFail($id);
        return new ResourcesBorrower($borrower);
    }

    public function findByName(int $name) {
        $borrowers = Borrower::where('last_name', 'like', '%' . $name . '%')
        ->orWhere(
            'first_name', 'like', '%' . $name . '%'
        )->get();
        return ResourcesBorrower::collection($borrowers);
    }

    public function saveBorrower(Request $request) {
        $borrower = $this->validation($request);

        Borrower::create($borrower);

        return response()->json(['success' => 'New Borrower has been add']);
    }

    public function updateBorrower(Request $request, int $id){

        $borrower = Borrower::where('id', $id)->firstOrFail();

        $borrower->update($this->validation($request));
        
        return response()->json(['success' => 'Borrower has been update']);
    }

    public function deleteBorrower(int $id) {

        $borrower = Borrower::findOrFail($id);

        $borrower->delete();

        return response()->json(['success' => 'Borrower has been deleted']);
    }

    private function validation(Request $request) {
        return $request->validate([
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|integer',
            'adresse' => 'required|string'
        ]);
    }

}

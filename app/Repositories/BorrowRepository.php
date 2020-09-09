<?php

namespace App\Repositories;

use App\Book;
use App\Borrow;
use App\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class BorrowRepository {

    private $loan;

    private $book;

    private $borrower;

    public function __construct(Borrow $borrow, Book $book, Borrower $borrower)
    {
        $this->book = $book;

        $this->borrower = $borrower;

        $this->loan = $borrow;
    }

    public function getBorrows(){
        $this->loan->newQuery()->all();
    }

    public function createLoan(Request $request){
        $book = $this->getBook($request->get('book_id'));
        
        if($book->available_copy > 0) {
            $loanOk = $this->loan->newQuery()->create([
                $this->validation($request)
            ]);
            if ($loanOk) {
                $book->update([
                    'available_copy' => $book->available_copy - 1,
                    'borrow_copy' => $book->borrow_copy + 1
                ]);
            }
        } else {
            return response()->json([
                'error' => 'No available copy for ' . $book->title
            ]);
        }
        
        return response()->json([
            'success' => 'New Loan has been save'
        ]);
    }

    public function loanBack(){

        $this->loan->newQuery()->update(['back_at' => Date::now()]);

    }

    public function updateLoan(Request $request, int $id) {

        $loan = $this->loan->newQuery()->findOrFail($id);

        $loan->newQuery()->update($this->validation($request));

        return response()->json([
            'success' => 'Loan updated successfuly'
        ]);
    }

    public function deleteLoan(int $id) {
        $this->loan->newQuery()->findOrFail($id)->delete();
    }

    private function validation(Request $request) {
        return $request->validate([
           'borrower_id' => 'required',
           'book_id' => 'required',
           'borrow_type' => 'required|string',
           'borrow_date' => 'required|date',
           'back_date' => '',
           'back_at' => '', 
        ]);
    }

    private function getBook(int $id) {
        return $this->book->newQuery()->findOrFail($id);
    }
}

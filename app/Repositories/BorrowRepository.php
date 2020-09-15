<?php

namespace App\Repositories;

use App\Book;
use App\Borrow;
use App\Borrower;
use App\Http\Resources\Borrow as ResourcesBorrow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class BorrowRepository
{

    private $loan;

    private $book;

    private $borrower;

    public function __construct(Borrow $borrow, Book $book, Borrower $borrower)
    {
        $this->book = $book;

        $this->borrower = $borrower;

        $this->loan = $borrow;
    }

    public function getAll()
    {
        return ResourcesBorrow::collection($this->loan->newQuery()->paginate());
    }

    public function createLoan(Request $request)
    {
        $book = $this->getBook($request->get('book_id'));

        if ($book->available_copy > 0 and $book->num_copy > $book->borrow_copy) {
            $loanOk = $this->loan->newQuery()->create(
                $this->validation($request)
            );
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

    public function loanBack(int $id): JsonResponse
    {

        $loan = $this->getLoan($id);
        $book = $this->getBook($loan->book_id);

        if ($book->borrow_copy >= 1 and $book->num_copy > $book->available_copy) {
            $book->update([
                'available_copy' => $book->available_copy + 1,
                'borrow_copy' => $book->borrow_copy - 1
            ]);
        } else {
            return response()->json([
                'error' => $book->title . ' has not been loan'
            ]);
        }

        $loan->newQuery()->update(['back_at' => Date::now()]);

        return response()->json([
            'success' => 'laon return successfuly'
        ]);
    }

    public function updateLoan(Request $request, int $id)
    {

        $loan = $this->getLoan($id);
        $book = $this->getBook($loan->book_id);
        if ($book->borrow_copy >= 1) {
            $book->update([
                'available_copy' => $book->available_copy + 1,
                'borrow_copy' => $book->borrow_copy - 1
            ]);
        } else {
            return response()->json([
                'error' => $book->title . ' has not been loan'
            ]);
        }
        $loan->newQuery()->update($this->validation($request));

        return response()->json([
            'success' => 'Loan updated successfuly'
        ]);
    }

    public function deleteLoan(int $id): JsonResponse
    {
        $loan = $this->loan->newQuery()->find($id);
        if ($loan) {
            $book = $this->getBook($loan->book_id);

            if ($book->borrow_copy >= 1 and $book->num_copy > $book->available_copy) {
                $book->update([
                    'available_copy' => $book->available_copy + 1,
                    'borrow_copy' => $book->borrow_copy - 1
                ]);
            } else {
                return response()->json([
                    'error' => $book->title . ' has not been loan'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'loan not found'
            ], 404);
        }

        $loan->delete();

        return response()->json([
            'success' => 'loan was deleted successfully'
        ], 200);
    }

    private function validation(Request $request)
    {
        return $request->validate([
            'borrower_id' => 'required',
            'book_id' => 'required',
            'borrow_type' => 'required',
            'back_date' => '',
        ]);
    }

    private function getBook(int $id)
    {
        return $this->book->newQuery()->findOrFail($id);
    }

    private function getLoan(int $id)
    {
        return $this->loan->newQuery()->findOrFail($id);
    }
}

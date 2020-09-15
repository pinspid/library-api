<?php

namespace App\Http\Controllers;

use App\Repositories\BorrowRepository;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    private $borrowRepository;

    public function __construct(BorrowRepository $borrowRepository){
        $this->borrowRepository = $borrowRepository;
    }

    public function index()
    {
        return $this->borrowRepository->getAll();
    }

    public function store(Request $request) 
    {
        return $this->borrowRepository->createLoan($request);
    }

    public function comeback(int $id){
        return $this->borrowRepository->loanBack($id);
    }

    public function destroy(int $id) {
        return $this->borrowRepository->deleteLoan($id);
    }
}

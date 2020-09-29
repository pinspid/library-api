<?php

namespace App\Http\Controllers;

use App\Repositories\BorrowerRepository;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    private $borrowerRepository;

    public function __construct(BorrowerRepository $borrowerRepository)
    {
        return $this->borrowerRepository = $borrowerRepository;
    }

    public function index(){
        return $this->borrowerRepository->all();
    }

    public function store(Request $request){
        return $this->borrowerRepository->saveBorrower($request);
    }

    public function show(int $id) {
        return $this->borrowerRepository->getLoanBook($id);
    }

    public function findByName(string $name) {
        return $this->borrowerRepository->findByName($name);
    }

    public function update(Request $request, int $id) {
        return $this->borrowerRepository->updateBorrower($request, $id);
    }

    public function destroy(int $id) {
        return $this->borrowerRepository->deleteBorrower($id);
    }
}

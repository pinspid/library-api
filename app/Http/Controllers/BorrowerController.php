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
        $this->borrowerRepository->all();
    }

    public function store(Request $request){
        $this->borrowerRepository->saveBorrower($request);
    }

    public function show(int $id) {
        $this->borrowerRepository->findById($id);
    }

    public function findByName(string $name) {
        $this->borrowerRepository->findByName($name);
    }

    public function update(Request $request, int $id) {
        $this->borrowerRepository->updateBorrower($request, $id);
    }

    public function destroy(int $id) {
        $this->borrowerRepository->deleteBorrower($id);
    }
}

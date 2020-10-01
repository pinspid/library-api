<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Borrower;
use App\Book;

class Borrow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'borrower' => Borrower::findOrFail($this->borrower_id),
            'book' => Book::findOrFail($this->book_id),
            'type' => $this->borrow_type,
            'date' => $this->borrow_date->diffForHumans(),
            'back_date' => $this->back_date->diffForHumans(),
            'back' => ($this->back_at != null) ? $this->back_at->diffForHumans() : '-'
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'borrower_id' => $this->borrower_id,
            'book_id' => $this->book_id,
            'borrow_type' => $this->borrow_type,
            'borrow_date' => $this->borrow_date,
            'back_date' => $this->back_date,
            'back' => ($this->back_at != null) ? $this->back_at->diffForHumans() : 'En Cours de prêt...'
        ];
    }
}

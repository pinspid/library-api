<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'edition' => $this->edition,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'year_publish' => $this->year_publish,
            'available_copy' => $this->available_copy,
            'num_copy' => $this->num_copy,
            'borrow_copy' => $this->borrow_copy,
        ];
    }
}

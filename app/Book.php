<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 
        'category_id',
        'edition', 
        'author', 
        'publisher', 
        'year_publish', 
        'num_copy', 
        'available_copy', 
        'borrow_copy'
    ];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function borrowers(){
        return $this->belongsToMany('App\Borrower', 'borrows', 'book_id', 'borrower_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $fillable = [
        'last_name', 
        'first_name', 
        'email', 
        'phone',
        'adresse'
    ];

    public function books()
    {
        return $this->belongsToMany('App\Book', 'borrows', 'borrower_id', 'book_id');
    }
}

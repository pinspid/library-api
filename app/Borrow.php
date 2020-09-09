<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{

    protected $fillable = [
        'borrower_id', 'book_id', 'borrow_type', 'borrow_date', 'back_date', 'back'
    ];

    protected $timestamps = false;

    protected $dates = ['borrow_date', 'back_date'];
}

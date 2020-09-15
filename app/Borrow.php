<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'borrower_id', 'book_id', 'borrow_type','back_date', 'back_at'
    ];

    public $timestamps = false;

    protected $dates = ['borrow_date', 'back_date', 'back_at'];
}

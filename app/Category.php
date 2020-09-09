<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['wording'];

    public function books(){
        return $this->hasMany('App\Book');
    }
}

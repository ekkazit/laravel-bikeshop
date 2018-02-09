<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['name', 'price'];

    public function category() {
        return $this->belongsTo('App\Category');
    }
}

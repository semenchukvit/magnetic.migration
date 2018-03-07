<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['id', 'title', 'body_html', 'price'];

    public $timestamps = false;

    protected $keyType = 'decimal';

    public function collections()
    {
        return $this->belongsToMany('App\Collection');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    //
    protected $fillable = ['id', 'title', 'body_html'];

    public $timestamps = false;

    protected $keyType = 'decimal';

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}

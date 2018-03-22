<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function saveData($data)
    {
        try {
            DB::table($this->getTable())->insert([
                'id' => $data->id,
                'title' => $data->title,
                'body_html' => $data->body_html,
                'price' => $data->variants[0]->price,
            ]);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }
}
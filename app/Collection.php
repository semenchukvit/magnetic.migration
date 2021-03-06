<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function saveData($data)
    {
        try {
            DB::table($this->getTable())->insert([
                'id' => $data->id,
                'title' => $data->title,
                'body_html' => $data->body_html,
            ]);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }
}

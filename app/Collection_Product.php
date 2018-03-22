<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Collection_Product extends Model
{
    protected $fillable = ['collection_id', 'product_id'];

    public $timestamps = false;

    protected $keyType = 'decimal';

    protected $table = 'collection_product';

    public function saveData($data)
    {
        try {
            DB::table($this->getTable())->insert([
                'collection_id' => $data->collection_id,
                'product_id' => $data->product_id,
            ]);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    //
    public function show()
    {
        $collections = Collection::all();

        $columns = Schema::getColumnListing('collections');

        return view('site.collections', [

                                                'collections' => $collections,
                                                'columns' => $columns,

                                                ]);
    }
}

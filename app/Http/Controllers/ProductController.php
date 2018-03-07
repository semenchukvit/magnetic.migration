<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    //
    public function show(Request $request, $id)
    {
        $products = Collection::find($id)->products;

        $columns = Schema::getColumnListing('products');

        return view('site.products', [

                                            'products' => $products,
                                            'columns' => $columns,

                                            ]);
    }
}

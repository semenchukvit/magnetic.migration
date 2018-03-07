<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MigrateController extends Controller
{
    //
    public function show()
    {
        return view('site.migrate');
    }

    public function store(Request $request)
    {
        $login = strtolower($request->login);
        $apiKey = $request->key;
        $pass = $request->password;

        //store products
        $productsUrl = $this->makeUrl($apiKey, $pass, $login,'products');
        $productsData = json_decode(file_get_contents($productsUrl));
        $product = new Product;
        foreach ($productsData->products as $item) {
            if (!Product::find($item->id)) {
                $product->create([
                    'id' => $item->id,
                    'title' => $item->title,
                    'body_html' => $item->body_html,
                    'price' => $item->variants[0]->price,
                ]);
            }
        }

        //store collections
        $collectionsUrl = $this->makeUrl($apiKey, $pass, $login,'custom_collections');
        $collectionsData = json_decode(file_get_contents($collectionsUrl));
        $collection = new Collection;
        foreach ($collectionsData->custom_collections as $item) {
            if (!Collection::find($item->id)) {
                $collection->create([
                    'id' => $item->id,
                    'title' => $item->title,
                    'body_html' => $item->body_html,
                ]);
            }
        }

        //store auxiliary table for relationship
        $collectsUrl = $this->makeUrl($apiKey, $pass, $login,'collects');
        $collectsData = json_decode(file_get_contents($collectsUrl));

        foreach ($collectsData->collects as $item) {

            $currentCollectProduct = DB::table('collection_product')
                                            ->where('collection_id', $item->collection_id)
                                            ->where('product_id', $item->product_id)
                                            ->first();

            if (!($currentCollectProduct)) {
                DB::table('collection_product')->insert([
                    'collection_id' => $item->collection_id,
                    'product_id' => $item->product_id,
                ]);
            }
        }

        return redirect()->back()->with('message', 'Migration complete');

    }

    private function makeUrl($key, $pass, $login, $type)
    {
        return 'https://'.$key.':'.$pass.'@'.$login.'.myshopify.com/admin/'.$type.'.json';
    }
}

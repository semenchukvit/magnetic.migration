<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Collection_Product;
use App\Product;
use App\Shopify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MigrateController extends Controller
{
    //
    public function show()
    {
        return view('site.migrate');
    }

    public function store(Request $request)
    {

        $input = $request->except('_token');

        $validator = Validator::make($input, [
            'login' => 'required',
            'key' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $shopify = new Shopify;
        $shopify->setCredentials($input['login'], $input['key'], $input['password']);

        //get products from Shopify
        $shopify->setURL('products');

        if ($shopify->validateUrlFails()) {
            return redirect()->back()->with('message_danger', $shopify->getCurrentErrorMessage())->withInput();
        }

        $productsData = $shopify->getData();

        //save products to DB
        $product = new Product;
        foreach ($productsData->products as $item) {
            if (!Product::find($item->id)) {
                if (!$product->saveData($item)) {
                    return redirect()->back()->with('message_danger', 'Data not saved')->withInput();
                };
            }
        }



        //get collections from Shopify
        $shopify->setURL('custom_collections');

        if ($shopify->validateUrlFails()) {
            return redirect()->back()->with('message_danger', $shopify->getCurrentErrorMessage())->withInput();
        }

        $collectionsData = $shopify->getData();

        //save collections to DB
        $collection = new Collection;
        foreach ($collectionsData->custom_collections as $item) {
            if (!Collection::find($item->id)) {
                if (!$collection->saveData($item)) {
                    return redirect()->back()->with('message_danger', 'Data not saved')->withInput();
                }
            }
        }



        //get auxiliary table for relationship from Shopify
        $shopify->setURL('collects');

        if ($shopify->validateUrlFails()) {
            return redirect()->back()->with('message_danger', $shopify->getCurrentErrorMessage())->withInput();
        }

        $relationsData = $shopify->getData();

        //save auxiliary table for relationship to DB
        $rellation = new Collection_Product;
        foreach ($relationsData->collects as $item) {
            $currentRellation = Collection_Product::where('collection_id', $item->collection_id)
                                ->where('product_id', $item->product_id)
                                ->first();

            if (!$currentRellation) {
                if (!$rellation->saveData($item)) {
                    return redirect()->back()->with('message_danger', 'Data not saved')->withInput();
                }
            }
        }



        return redirect()->back()->with('message_success', 'Migration complete');

    }
}

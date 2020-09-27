<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    /*
    * @var array
    */
    protected $fillable = [
        'platform',
    ];

    /**
     * @param $productDetails
     * @return array
     */
    public function shopify($productDetails) {
        $productList = [];
        $prodVariants = [];
        foreach ($productDetails['products'] as $products) {

            foreach ($products['variants'] as $variants) {
                $prodVariants[$products['id']][] = [
                    'color' => ($variants['option1']) ?? "",
                    'size' => ($variants['size']) ?? "",
                    'quantity' => ($variants['inventory_quantity']) ?? "",
                    'weight' => ($variants['weight']) ?? "",
                    'price' => ($variants['price']) ?? "",

                ];
            }
            $productList[] = [
                'productId' => $products['id'],
                'name' => $products['title'],
                'variants' => $prodVariants[$products['id']]
            ];
        }
        return $productList;
    }

    /**
     * @param $productDetails
     * @return array
     */
    public function woocommerce($productDetails) {
        $productList = [];
        $prodVariants = [];
        foreach ($productDetails as $products) {
            $attributes = (empty($products['attributes'])) ? $products['default_attributes'] : $products['attributes'];
            foreach ($attributes as $attr) {
                $prodVariants[$products['id']][$attr['name']] = ($attr['options']) ?? $attr['option'];
            }
            $prodVariants[$products['id']]['quantity'] = ($products['stock_status']) ?? "";
            $prodVariants[$products['id']]['weight'] = ($products['weight']) ?? "";
            $prodVariants[$products['id']]['price'] = ($products['price']) ?? "";
            $productList[] = [
                'productId' => $products['id'],
                'name' => $products['name'],
                'variants' => $prodVariants[$products['id']]
            ];
        }
        return $productList;
    }
}

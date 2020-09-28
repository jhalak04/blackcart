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
                    'quantity' => ($variants['inventory_quantity']) ?? "",
                    'weight' => ($variants['weight']) ?? "",
                    'price' => ($variants['price']) ?? "",
                    'size' => ($variants['size']) ?? "",
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
                if (isset($attr['options'])) {
                    $prodVariants[$products['id']][] =  $this->x($attr['options'], $products);
                } else {
                    $keyName = ($attr['name'] == 'Color') ? 'color' : 'size';
                    $newOptns[$keyName] = $attr['option'];
                    $newOptns['quantity'] = ($products['stock_status']) ?? "";
                    $newOptns['weight'] = ($products['weight']) ?? "";
                    $newOptns['price'] = ($products['price']) ?? "";
                    $prodVariants[$products['id']] = [$newOptns];
                }
            }
            $productList[] = [
                'productId' => $products['id'],
                'name' => $products['name'],
                'variants' => $prodVariants[$products['id']]
            ];
        }
        return $productList;
    }

    private function x($options, $products) {
        $newOptns = [];
        foreach ($options as $key => $nOpt) {
            $keyName = ($key == 'Color') ? 'color' : 'size';
            $newOptns[$keyName] = $nOpt;
            $newOptns['quantity'] = ($products['stock_status']) ?? "";
            $newOptns['weight'] = ($products['weight']) ?? "";
            $newOptns['price'] = ($products['price']) ?? "";
        }
        return $newOptns;
    }
}

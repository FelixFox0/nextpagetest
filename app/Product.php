<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    public static function getProducts($category_id, $city_id, $sort, $order)
    {
        $query = static::select()
                ->join('categories_products', 'products.id', '=', 'categories_products.product_id')
                ->where('categories_products.category_id', '=', $category_id)
                ->select('products.id', 'products.name', 'products.slug')
                ->get();
        
        foreach ($query as $product) {
            $stock = static::select()
                    ->join('products_towns', 'products.id', '=', 'products_towns.product_id')
                    ->join('towns', 'towns.id', '=', 'products_towns.town_id')
                    ->where('products.id', '=', $product->id);
            if($city_id){
                $stock = $stock->where('towns.id', '=', $city_id);
            }
            
            $stock = $stock->select('towns.id', 'towns.name', 'towns.slug', 'products_towns.quantity', 'products_towns.price');
            if($sort && $order){
//                dd('products_towns.'.$sort, $order);
                $stock = $stock->orderBy('products_towns.'.$sort, $order);
            }
                $stock = $stock->get();
            
            $products[] = array(
                'id' => $product->id,
                'name' => $product->id,
                'slug' => $product->id,
                'url' => $product->id,
                'stock' => $stock,
            );
        }
//        dd($products);
        return $products;
    }
}

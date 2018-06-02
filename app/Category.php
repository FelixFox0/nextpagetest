<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    public $category_id;
    
    public static function getIdBySlug($slug)
    {
        return static::select()->where('slug', '=', $slug)->first();
    }
    
    public static function getChildCategories($id){
        
        $query = static::select()
                ->where('category_id', '=', $id)
                ->get();
//        var_dump(get_object_vars($query));
        if(get_object_vars($query)){
            foreach ($query as $child){
                $child_categories[] = array(
                    'id' => $child->id,
                    'name' => $child->name,
                    'url' => '/catalog/'.$child->slug.'/'
                );
            }
        }else{
            $child_categories = array();
        }
        return $child_categories;
    }
    
    public static function getStockInCities($category_id){
        $cities = static::select()
                ->join('categories_products', 'categories.id', '=', 'categories_products.category_id')
                ->join('products', 'products.id', '=', 'categories_products.product_id')
                ->join('products_towns', 'products.id', '=', 'products_towns.product_id')
                ->join('towns', 'towns.id', '=', 'products_towns.town_id')
                ->where('products_towns.quantity', '>', 0)
                ->where(function ($query) use($category_id) {
                    $query->where('categories.id', '=', $category_id)
                        ->orWhere('categories.category_id', '=', $category_id);
                    })
                ->select('towns.id','towns.name','towns.slug')
                ->groupby('towns.id')
                ->get();
        return $cities;
    }
}

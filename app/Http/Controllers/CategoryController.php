<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Town;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_slug, Request $request)
    {
        if($category = Category::getIdBySlug($category_slug)){
            $data = array();
            if(isset($request->city)){
                if($city = Town::getIdBySlug($request->city)){
                    $city_id = $city->id;
                }else{
                    abort(404);
                }
            }else{
                $city_id = 0;
            }
            $sort_order = $request->sort ?? '';
            if($sort_order){
                $sort_order = explode('_', $sort_order);
                $sort = array_shift($sort_order);
            }else{
                $sort = 'price';
            }
            if($sort_order){
                $order = array_pop($sort_order);
            }else{
                $order = 'asc';
            }

            $data['products'] = Product::getProducts($category->id, $city_id, $sort, $order);
            $data['child_categories'] = Category::getChildCategories($category->id);
            $data['cities'] = Category::getStockInCities($category->id);
            $data['breadcrumbs'][0] = array(
                'name' => 'Главная',
                'url' => '/',
            );
            $data['breadcrumbs'][1] = array(
                'name' => 'Каталог',
                'url' => '/catalog',
            );
            $data['breadcrumbs'][2] = array(
                'name' => $category->name,
                'url' => '/catalog/'. $category->slug,
            );
//            dd($data);
            return response()->json($data);
        }else{
            abort(404);
        }
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

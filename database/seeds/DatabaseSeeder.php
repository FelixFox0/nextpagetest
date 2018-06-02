<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Category;
use App\Town;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(DemoSeeder::class);
    }
}

class DemoSeeder extends Seeder
{
    public function run()
    {
        /*
        DB::table('products_towns')->delete();
        DB::table('categories_products')->delete();
        DB::table('products')->delete();
        DB::table('categories')->delete();
        DB::table('towns')->delete();*/
        
        $product1 = Product::create([
            'name' => 'Product 1',
            'slug' => 'product_1'
        ]);
        $product2 = Product::create([
            'name' => 'Product 2',
            'slug' => 'product_2'
        ]);
        
        $topcategory = Category::create([
            'name' => 'Top category',
            'slug' => 'top_category'
        ]);
        $category = Category::create([
            'category_id' => $topcategory->id,
            'name' => 'Category',
            'slug' => 'category'
        ]);
        
        $kyiv = Town::create([
            'name' => 'Киев',
            'slug' => 'kyiv'
        ]);
        $kharkiv = Town::create([
            'name' => 'Харьков',
            'slug' => 'kharkiv'
        ]);
        
        DB::table('products_towns')->insert([
            'product_id' => $product1->id,
            'town_id' => $kyiv->id,
            'quantity' => 10,
            'price' => 15,
        ]);
        DB::table('products_towns')->insert([
            'product_id' => $product1->id,
            'town_id' => $kharkiv->id,
            'quantity' => 0,
            'price' => 17.99,
        ]);
        DB::table('products_towns')->insert([
            'product_id' => $product2->id,
            'town_id' => $kyiv->id,
            'quantity' => 7,
            'price' => 20.99,
        ]);
        DB::table('products_towns')->insert([
            'product_id' => $product2->id,
            'town_id' => $kharkiv->id,
            'quantity' => 0,
            'price' => 35.15,
        ]);
        
        DB::table('categories_products')->insert([
            'product_id' => $product1->id,
            'category_id' => $topcategory->id,
        ]);
        DB::table('categories_products')->insert([
            'product_id' => $product2->id,
            'category_id' => $topcategory->id,
        ]);
        DB::table('categories_products')->insert([
            'product_id' => $product2->id,
            'category_id' => $category->id,
        ]);
    }
}

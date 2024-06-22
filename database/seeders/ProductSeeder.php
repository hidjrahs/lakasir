<?php

namespace Database\Seeders;

use App\Models\Tenants\Product;
use Illuminate\Database\Seeder;
use App\Models\Tenants\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // Product::truncate();
        // Product::factory()->create();


        // $table->foreignId('category_id')->constrained();
        // $table->string('name');
        // $table->double('stock');
        // $table->double('initial_price');
        // $table->double('selling_price');
        // $table->string('unit')->default("PCS");
        // $table->string('type')->default("product");
        // $table->string("sku")->nullable()->after("name");
        // $table->string("barcode")->nullable()->after("sku");
        // Product::truncate();
        DB::table('products')->delete();
        $json = File::get(public_path("data/data.json"));
        $jsonData = json_decode($json);

        foreach ($jsonData as $key => $value) {
            if (Product::where('barcode', $value->{'Kode Item'})->exists()) continue;
            $data = [
                "name" => $value->Satuan,
            ];
            $cotegoryId = Category::where('name', $value->Satuan)->first()->id ?? DB::table('categories')->insertGetId($data);
            Product::create([
                "category_id" => $cotegoryId,
                "name" => $value->{'Nama Item'},

                "barcode" => $value->{'Kode Item'},
                "unit" => 'PCS',
                "type" => 'product',
                "initial_price" => $value->{'Harga Pokok'},
                "selling_price" => $value->{'Harga Jual'},
                "stock" => rand(10, 50),
            ]);
        }
    }
}

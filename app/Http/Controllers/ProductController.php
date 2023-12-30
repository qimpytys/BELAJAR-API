<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make ($request->all(), [
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:food,beverage,drug,other',
            'product_price' => 'required|numeric',
            'expired_at' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages())->setStatusCode(422);
        }
        $payload = $validator->validated();

        Product::create([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at'],
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Ditambahkan'
        ], 200 );
    }


    function showAll(Request $request){

        //showbyname

        $productName = $request->input('name');

        //showbytype

        $productType = $request->input('type');

        if (!empty($productName)) {
            $product = Product::where('product_name', $productName)->get();
            if ($product->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Produk dengan nama ' . $productName . ' tidak ditemukan.',
                    'data' => null
                ], 404);
            }
        }elseif (!empty($productType)) {
            $product = Product::where('product_type', $productType)->get();
            if ($product->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Produk dengan tipe ' . $productType . ' tidak ditemukan.',
                    'data' => null
                ], 404);
            }
        }else {
            $product = Product::all();
        }

        return response()->json([
            'status'=> true,
            'message' => 'Data Semua Product',
            'data'=> $product
            ], 200 );
        }            

    function showById($id){
        $product = Product::find($id);
        if ($product){
            return response()->json([
                'status' => true,
                'message' => 'Data Product dengan ID : '. $id,
                'data'=> $product
            ], 200 );
        }
    return response()->json([
        'status' => false,
        'message' => 'Data Product dengan ID :'. $id. ' Tidak Ditemukan',
    ],404);

    }

    function UpdateProduct(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:food,beverage,drug,other',
            'product_price' => 'required|numeric',
            'expired_at' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages())->setStatusCode(422);
        }
        $payload = $validator->validated();
        $product = Product::find($id)->first();
        $product->update([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Di Update',
            'data' => $product, 
        ], 200 );
    }
    
    function deleteProduct($id){
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Data Product dengan ID :' . $id . ' Tidak Ditemukan',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Product dengan ID :' . $id . ' Berhasil Dihapus',
        ], 200);
    }
}
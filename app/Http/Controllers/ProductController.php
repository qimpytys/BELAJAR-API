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
            'msg' => 'Data Berhasil Ditambahkan'
        ], 200 );
    }


    function showAll(){
        $product = Product::all();

        return response()->json([
            'msg' => 'Data Semua Product',
            'data'=> $product
        ], 200 );

    }

    function showById($id){
        $product = Product::where('id', $id)->first();

        if ($product){
            return response()->json([
                'msg' => 'Data Product Berdasarkan ID : '. $id,
                'data'=> $product
            ], 200 );
        }
        return response()->json([
            'msg' => 'Data Product dengan ID :'. $id. ' Tidak Ditemukan',
        ],404);

    }

    function showByName(Request $request){
        $productName = $request->input('product_name');
        $product = Product::where('product_name', $productName)->get();

        if ($product) {
            return response()->json([
                'msg' => 'Data Product Berdasarkan Name:' .$productName,
                'data' => $product
            ],200);
        }
        return response()->json([
            'msg' => 'Data Product dengan Name :'. $productName. ' Tidak Ditemukan',
        ],404);

    }

    function showByType(Request $request){
        $product = Product::where('product_type', $request);

        if ($product) {
            return response()->json([
                'msg' => 'Data Product Berdasarkan Type:' .$request,
                'data' => $product
            ],200);
        }
        return response()->json([
            'msg' => 'Data Product dengan Name :'. $request. ' Tidak Ditemukan',
        ],404);

    }

    function UpdateProduct(Request $request, $id){
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
        $product = Product::updated([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at'],
        ]);

        return response()->json([
            'msg' => 'Data Berhasil Di Update',
            'data' => $product,
        ], 200 );

    }
    function deleteProduct($id){
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'msg' => 'Data Product dengan ID :' . $id . ' Tidak Ditemukan',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'msg' => 'Data Product dengan ID :' . $id . ' Berhasil Dihapus',
        ], 200);
    }

}

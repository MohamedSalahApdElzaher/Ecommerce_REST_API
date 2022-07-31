<?php

namespace App\Http\Controllers;

use App\Exceptions\NotBelongsToUser;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // you use collection() when there are more than a single record to get
        return ProductCollection::collection(Product::paginate(5));
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        Product::create([
            'name' => $data['name'],
            'details' => $data['details'],
            'price'=>$data['price'],
            'stock'=>$data['stock'],
            'discount'=>$data['discount']
        ]);
        return response()->json([
            'status' => 1,
            'msg' => 'product saved!',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // get one single record
        return new ProductResource($product);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->checkCurrentUser($product);
        $product->update($request->all());
        return response()->json([
            'status'=>1,
            'msg'=>'product updated',
            'product'=>$product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->checkCurrentUser($product);
        $product->delete();
        return response()->json([
            'status'=>1,
            'msg'=>'product deleted',
        ]);
    }

    private function checkCurrentUser($product){
        if(Auth::user()->id !== $product->user_id){
            throw new NotBelongsToUser();
        }
    }
}

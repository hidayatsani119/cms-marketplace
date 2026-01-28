<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //helper func to check is productExist
    function checkProductExists(int $product_id) : Product
    {
        $product = Product::where('id', $product_id)->first();
        if(!$product){
            throw new HttpResponseException(response()->json([
                'errors' => 'Product not found',

            ],404));
        }

        return $product;
    }
    public function create(ProductCreateRequest $request) : JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        $product = Product::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName =Str::uuid() . "." . $file->getClientOriginalExtension();
            $path = $file->storeAs('products', $fileName, 'public');
            $product->image_path = $path;
            $product->save();
        }

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product)
        ],201);
    }

    public function getAll() : JsonResponse
    {
        $products = Product::all();
        if($products->isEmpty()){
            throw new HttpResponseException(response()->json([
                'errors' => 'Product not found',

            ],404));
        }
        return response()->json([
            'message' => 'Products retrieved successfully',
            'data' => ProductResource::collection($products)
        ],200);
    }

    public function get(Request $request) :JsonResponse
    {
        $product_id = $request->route('product_id');
        $product = $this->checkProductExists($product_id);

        return response()->json([
            'message' => 'Product retrieved successfully',
            'data' => new ProductResource($product)
        ],200);
    }

    public function update(ProductCreateRequest $request) :JsonResponse
    {
        $data = $request->validated();
        $product_id = $request->route('product_id');

        $product = $this->checkProductExists($product_id);

        $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'status' => $data['status']
        ]);
        if($request->file('image')){
            $file = $request->file('image');
            $fileName =Str::uuid() . "." . $file->getClientOriginalExtension();
            $path = $file->storeAs('products', $fileName, 'public');
            $product->image_path = $path;
        }

        $product->save();
        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product)
        ],200);
    }

    public function delete(Request $request) :JsonResponse
    {
        $product_id = $request->route('product_id');
        $product = $this->checkProductExists($product_id);

        $product->delete();
         return response()->json([
             'message' => 'Product deleted successfully',
             'data' => null
         ],200);
    }

    public function search(ProductSearchRequest $request) :JsonResponse
    {
        $data = $request->validated();

        $query = Product::query();

        if(isset($data['name'])){
            $query->where('name', 'like', '%'.$data['name'].'%');
        }
        if(isset($data['order']))
        {
            if($data['order'] == 'latest'){
                $query->orderBy('id', 'asc');
            } else {
                $query->orderBy( 'id','desc');
            }
        }
        if(isset($data['price']))
        {
            if($data['price'] == 'lowest'){
                $query->orderBy('price' ,'asc');
            } else {
                $query->orderBy( 'price','desc');
            }
        }

        $perPage = 10;
        if (isset($data['perPage'])) {
            $perPage = $data['perPage'];
        }
        $products = $query->paginate($perPage);


        if($products->isEmpty()){
            throw new HttpResponseException(response()->json([
                'errors' => 'Product not found',
                'data' => null
            ],404));
        }

        return response()->json([
            'message' => 'Products retrieved successfully',
            'data' => ProductResource::collection($products),
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }
}

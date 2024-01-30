<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ProductRequest;
use App\Http\Resources\v1\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageCount = request()->get('page_count') ?? 4;
        // $query = Category::query();
        // if(request()->has('search')){
        //     $search = request()->get('search');
        //     $query->where('title', 'like', "%$search%");
        // }
        // $orderBy = request()->get('order_by') ?? 'created_at';
        // $orderDir = request()->get('order_dir') ?? 'desc';
        // $query->orderBy($orderBy, $orderDir);

        $product=Product::paginate($pageCount);
        return  ProductResource::collection($product->load('images'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $primaryImageName=Carbon::now()->microsecond .'.' . $request->primary_image->extension();
        $request->primary_image->storeAs('image/product',$primaryImageName,'public');

        if($request->has('images')){
            $fileNameImages=[];
            foreach($request->images as $image){
                $fileNameImage=Carbon::now()->microsecond .'.' . $image->extension();
                $image->storeAs('image/product',$fileNameImage,'public');
                array_push($fileNameImages,$fileNameImage);
            }
        }

        $product=Product::create([
            'occasion_id' => $request['occasion_id'],
            'category_id' => $request['category_id'],
            'name' => $request['name'],
            'primary_image' => $primaryImageName,
            'description' => $request['description'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
            'delivery_amount' => $request['delivery_amount'],
        ]);

        if($request->has('images')){
            foreach($fileNameImages as $fileNameImage){
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage,
                ]);
            }
        }
        return new ProductResource($product);
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product->load('images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        if($request->has('primary_image')){
            $primaryImageName=Carbon::now()->microsecond .'.' . $request->primary_image->extension();
            $request->primary_image->storeAs('image/product',$primaryImageName,'public');
        }
        if($request->has('images')){
            $fileNameImages=[];
            foreach($request->images as $image){
                $fileNameImage=Carbon::now()->microsecond .'.' . $image->extension();
                $image->storeAs('image/product',$fileNameImage,'public');
                array_push($fileNameImages,$fileNameImage);
            }
        }

        $product->update([
            'occasion_id' => $request['occasion_id'],
            'category_id' => $request['category_id'],
            'name' => $request['name'],
            'primary_image' => $request->has('primary_image') ? $primaryImageName : $product->primary_image,
            'description' => $request['description'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
            'delivery_amount' => $request['delivery_amount'],
        ]);

        if($request->has('images')){
            foreach($product->images as $productImage){
                $productImage->delete();
            }
            foreach($fileNameImages as $fileNameImage){
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage,
                ]);
            }
        }
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return new ProductResource($product);
    }
}

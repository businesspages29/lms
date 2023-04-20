<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $productQuery = Product::query();
        if($request->has('category_id')){
            $productQuery = $productQuery->CategoryId($request->get('category_id'));
        }
        $products = $productQuery->paginate(15);
        return view('front.index',compact('products'));
    }

    public function ajaxCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'parent_id' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $input = $request->only(['name','parent_id']);
        $input['slug'] = str()->slug($input['name']);
        Category::create($input);
        return response()->json([
            'message' => 'create successfully'
        ], 200);
    }
    
    public function ajaxProduct(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 200);
        }
        $input = $request->except('_token');
        $varaints = !empty($input['variant']) ? $input['variant'] : [];
        $input['slug'] = str()->slug($input['name']).date('-Ymdhis');
        unset($input['variant']);
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = $file->getClientOriginalName().date('-Ymdhis');
            $file->storeAs('public/products/',$filename);
            $input['image'] = $filename;
        }else{
            unset($input['image']);
        }
        $product = Product::create($input);
        if(!empty($product) && count($varaints) > 0){
            $x = 0;
            while($x <= count($varaints['name']) - 1) {
                $varaint['product_id'] = $product->id;
                $varaint['name'] = $varaints['name'][$x];
                $varaint['slug'] = str()->slug($varaint['name']).date('-Ymdhis');
                $varaint['price'] = $varaints['price'][$x];
                $varaint['offer_price'] = $varaints['offer_price'][$x];
                ProductVariant::create($varaint);
                $x++;
            }
            
        }
        return response()->json([
            'message' => 'create successfully'
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        // eager load category to avoid N+1
        $products = Product::with('category')->orderBy('created_at','desc')->get();
        return view('products.index', ['products' => $products]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'        => 'required',
            'sku'         => 'required|unique:products,sku',
            'price'       => 'required|numeric',
            'status'      => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('products.create')->withErrors($validator)->withInput();
        }

        $product = new Product();
        $product->name        = $request->name;
        $product->sku         = $request->sku;
        $product->price       = $request->price;
        $product->status      = $request->status;
        $product->category_id = $request->category_id; // category
        $product->save();

        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route('products.index')->with('success','Product created successfully.');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', ['product'=> $product, 'categories' => $categories]);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(),[
            'name'        => 'required',
            'sku'         => 'required|unique:products,sku,' . $product->id,
            'price'       => 'required|numeric',
            'status'      => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.edit', $product->id)->withErrors($validator)->withInput();
        }

        $product->name        = $request->name;
        $product->sku         = $request->sku;
        $product->price       = $request->price;
        $product->status      = $request->status;
        $product->category_id = $request->category_id; // category
        $product->save();

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($product->image && file_exists(public_path('uploads/products/'.$product->image))) {
                unlink(public_path('uploads/products/'.$product->image));
            }

            $image     = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route('products.index')->with('success','Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // delete image if exists
        if ($product->image && file_exists(public_path('uploads/products/'.$product->image))) {
            unlink(public_path('uploads/products/'.$product->image));
        }

        $product->delete();
        return redirect()->route('products.index')->with('success','Product deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Product; // <--- Add this line to import the Product model
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request$request)
    {
        $filter = $request->input('game'); // 'game' คือชื่อเกม เช่น 'genshin', 'starrail'

        if ($filter) {
            $products = Product::where('name', 'like', '%' . $filter . '%')->get();
        } else {
            $products = Product::all();
        }
        return view('choose', compact('products'));
    }
    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Amount' => 'required|numeric'
        ]);

        $product = new Product($request->only(['name', 'price', 'description', 'image','Amount']));

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('choose');
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('show', compact('product'));
    }
    public function listOFproduct()
    {
        $products = Product::all();
        return view('table_product', compact('products'));
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'price', 'description', 'Amount']));

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        return redirect()->back()->with('success', 'อัปเดตสินค้าเรียบร้อยแล้ว');
    }


}

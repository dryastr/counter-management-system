<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TypeProduct;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::with('typeProduct')->get();
        $typeProducts = TypeProduct::all();
        return view('admin.products.index', compact('products', 'typeProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type_product_id' => 'required|exists:type_products,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'discount' => 'nullable|numeric',
            'supplier' => 'required|max:100',
        ]);

        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type_product_id' => 'required|exists:type_products,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'discount' => 'nullable|numeric',
            'supplier' => 'required|max:100',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Produk berhasil diubah.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}

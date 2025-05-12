<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TypeProduct;
use Illuminate\Http\Request;

class TypesProductsController extends Controller
{
    public function index()
    {
        $typeProducts = TypeProduct::all();
        return view('admin.type_products.index', compact('typeProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        TypeProduct::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Type Product created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $typeProduct = TypeProduct::findOrFail($id);
        $typeProduct->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Type Product updated successfully.');
    }

    public function destroy($id)
    {
        $typeProduct = TypeProduct::findOrFail($id);
        $typeProduct->delete();

        return redirect()->back()->with('success', 'Type Product deleted successfully.');
    }
}

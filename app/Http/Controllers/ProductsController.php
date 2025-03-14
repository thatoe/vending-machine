<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(2);
        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
    {
        if (!$request->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.1',
            'quantity_available' => 'required|integer|min:1',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        if (!$request->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.1',
            'quantity_available' => 'required|integer|min:1',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    public function show(Product $product)
    {
        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }

    public function purchase(Product $product, Request $request) {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($product, $request) {
            // Create a new transaction record
            $product->transactions()->create([
                'user_id' => $request->user()->id,
                'quantity' => $request->quantity,
                'total_price' => $product->price * $request->quantity,
            ]);

            // Decrement the available quantity of the product
            $product->decrement('quantity_available', $request->quantity);
        });

        return redirect()->route('products.index')->with('success', 'Product purchased successfully!');
    }
}

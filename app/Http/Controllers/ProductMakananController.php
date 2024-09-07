<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductMakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Auth::user()->products;
        return view('dashboard.product.makanan.index', ['products' => $product]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.product.makanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validasi data input
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);


        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $validatedData['merchant_id'] = Merchant::where('user_id', Auth::id())->first()->id;
        $validatedData['user_id'] = Auth::id();
        $validatedData['type'] = "Makanan";


        Product::create($validatedData);

        return redirect('/dashboard/product')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        return view('dashboard.product.makanan.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);


        if ($request->hasFile('image')) {

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }


            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }


        $validatedData['merchant_id'] = $product->merchant_id;
        $validatedData['user_id'] = Auth::id();
        $validatedData['type'] = $product->type ?? 'Makanan';


        $product->update($validatedData);

        return redirect('/dashboard/product')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus produk dari database
        $product->delete();

        // Redirect dengan pesan sukses
        return redirect('/dashboard/product')->with('success', 'Produk berhasil dihapus.');
    }
}

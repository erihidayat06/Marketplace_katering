<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function create()
    {
        return view('daftarMerchant.index');
    }
    public function index()
    {
        $profile = Merchant::where('id', 1)->get()[0];
        return view('dashboard.profile', ['profile' => $profile]);
    }

    public function store(Request $request)
    {

        $slug = $this->createSlug($request->input('company_name'));


        $validateData = $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);


        $validateData['user_id'] = Auth::id();
        $validateData['slug'] = $slug;
        // Simpan data ke database
        Merchant::create($validateData);


        return redirect('dashboard')->with('success', 'Company information saved successfully.');
    }


    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validasi gambar
            'tag' => 'nullable|string',
        ]);

        $merchant = Merchant::where('user_id', Auth::id())->first();

        if ($request->hasFile('image')) {
            if ($merchant->image) {
                Storage::delete('public/images/' . $merchant->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        }

        $merchant->update($validatedData);

        return redirect('dashboard')->with('success', 'Profil berhasil diperbarui.');
    }

    public function merchant(Merchant $merchant)
    {
        // Mengambil semua produk milik merchant
        $products = $merchant->product;

        // Mengambil transaksi unik berdasarkan merchant_id
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('merchant_id', $merchant->id)
            ->get();

        // Mengambil semua detail transaksi untuk perhitungan total
        $transactionDetails = Transaction::where('user_id', Auth::id())
            ->where('merchant_id', $merchant->id)
            ->with('product') // Mengambil data produk terkait setiap transaksi
            ->get();

        // Menghitung total quantity dan total harga
        $totalQuantity = $transactionDetails->sum('quantity');
        $totalPrice = $transactionDetails->sum(function ($transaction) {
            return $transaction->quantity * $transaction->product->price; // Menghitung harga total
        });



        return view('merchant.index', [
            'merchant' => $merchant,
            'products' => $products,
            'transactions' => $transactions,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }




    private function createSlug($string)
    {

        $slug = strtolower($string);


        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);


        $slug = preg_replace('/[\s-]+/', '-', $slug);


        $slug = trim($slug, '-');


        $date = date('Y-m-d H:i:s');


        $dateHash = substr(md5($date), 0, 16);


        return $slug . '-' . $dateHash;
    }
}

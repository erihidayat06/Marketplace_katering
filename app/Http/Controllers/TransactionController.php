<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'merchant_id' => 'required|exists:merchants,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);


        $validatedData['user_id'] = Auth::id();

        // $validatedData['kode_pesanan'] = $this->generateOrderCode();


        Transaction::create($validatedData);


        return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
    }

    private function generateOrderCode()
    {
        // Menghasilkan kode acak dengan huruf dan angka sepanjang 14 karakter
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $orderCode = substr(str_shuffle(str_repeat($characters, 14)), 0, 14);
        return $orderCode;
    }
}

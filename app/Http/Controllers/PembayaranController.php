<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Penjualan;

class PembayaranController extends Controller
{
    /**
     * Menyimpan data pembayaran baru ke dalam database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari permintaan
        $validatedData = $request->validate([
            'penjualan_id' => 'required|exists:penjualan,id', 
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string', 
            'payment_date' => 'required|date', 
        ]);

        // Menemukan penjualan berdasarkan ID yang diberikan
        $penjualan = Penjualan::findOrFail($validatedData['penjualan_id']);

        // Menghitung total pembayaran yang sudah dilakukan untuk penjualan ini
        $totalPaid = $penjualan->pembayaran()->sum('amount');

        // Periksa apakah total pembayaran melebihi jumlah total yang harus dibayar
        if ($totalPaid + $validatedData['amount'] > $penjualan->grand_total) {
            // Kembalikan respons jika pembayaran melebihi jumlah total
            return response()->json(['message' => 'Pembayaran melebihi jumlah total yang harus dibayar.'], 400);
        }

        // Simpan data pembayaran baru ke dalam database
        $pembayaran = Pembayaran::create([
            'penjualan_id' => $validatedData['penjualan_id'],
            'amount' => $validatedData['amount'],
            'payment_method' => $validatedData['payment_method'],
            'payment_date' => $validatedData['payment_date'],
        ]);

        // Kembalikan respons dengan data pembayaran yang baru dibuat
        return response()->json($pembayaran, 201);
    }

    /**
     * Mengambil semua data pembayaran dari database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Ambil semua data pembayaran
        $pembayaran = Pembayaran::all();

        // Kembalikan respons dengan data pembayaran
        return response()->json($pembayaran);
    }
}

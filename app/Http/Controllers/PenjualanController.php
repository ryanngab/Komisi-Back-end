<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Mengambil semua data penjualan dari database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Ambil seluruh data penjualan
        $penjualans = Penjualan::all();

        // Kembalikan data penjualan dalam format JSON
        return response()->json($penjualans);
    }

    /**
     * Menyimpan data penjualan baru ke dalam database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi data input dari pengguna
        $validatedData = $this->validatePenjualanData($request);

        // Generate nomor transaksi baru
        $transactionNumber = $this->generateTransactionNumber();

        // Hitung grand_total
        $grandTotal = $this->calculateGrandTotal(
            $validatedData['cargo_fee'],
            $validatedData['total_balance']
        );

        // Tambahkan grand_total dan transaction_number ke data yang sudah divalidasi
        $validatedData['grand_total'] = $grandTotal;
        $validatedData['transaction_number'] = $transactionNumber;

        // Buat record penjualan baru di database
        $penjualan = Penjualan::create($validatedData);

        // Kembalikan data penjualan yang baru dibuat dengan status 201
        return response()->json($penjualan, 201);
    }

    /**
     * Validasi data input penjualan.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function validatePenjualanData(Request $request)
    {
        return $request->validate([
            'marketing_id' => 'required|exists:marketing,id',
            'date' => 'required|date', 
            'cargo_fee' => 'required|integer|min:0',
            'total_balance' => 'required|integer|min:0',
        ]);
    }

    /**
     * Menghitung grand_total dari biaya kargo dan saldo total.
     *
     * @param int $cargoFee
     * @param int $totalBalance
     * @return int
     */
    private function calculateGrandTotal(int $cargoFee, int $totalBalance): int
    {
        return $cargoFee + $totalBalance;
    }

    /**
     * Menghasilkan nomor transaksi berikutnya.
     *
     * @return string
     */
    private function generateTransactionNumber(): string
    {
        // Ambil nomor transaksi terakhir
        $latestPenjualan = Penjualan::orderBy('transaction_number', 'desc')->first();

        // Inisialisasi nomor transaksi berikutnya
        $nextNumber = '001';

        if ($latestPenjualan) {
            // Ambil bagian numerik dari nomor transaksi terakhir
            $latestNumber = (int) substr($latestPenjualan->transaction_number, 3);

            // Increment nomor dan format dengan angka nol di depan
            $nextNumber = str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        // Kembalikan nomor transaksi yang sudah diformat
        return 'TRX' . $nextNumber;
    }
}

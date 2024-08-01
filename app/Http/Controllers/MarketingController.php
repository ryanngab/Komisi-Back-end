<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marketing;
use App\Models\Penjualan;

class MarketingController extends Controller
{
    /**
     * Mengambil semua data marketing.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Ambil seluruh data marketing dari database
        $marketings = Marketing::all();

        // Kembalikan data marketing dalam format JSON
        return response()->json($marketings);
    }

    /**
     * Menyimpan data marketing baru ke dalam sistem.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input untuk nama marketing
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Buat objek Marketing baru dan simpan data
        $marketing = new Marketing();
        $marketing->name = $request->input('name');
        $marketing->save();

        // Kembalikan respons dengan pesan sukses
        return response()->json(['message' => 'Marketing berhasil dibuat']);
    }

    /**
     * Menghitung komisi untuk setiap marketing berdasarkan omzet penjualan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function komisi()
    {
        // Ambil semua data marketing dan penjualan
        $marketings = Marketing::all();
        $penjualans = Penjualan::all();

        // Array untuk menyimpan hasil perhitungan komisi
        $hasil = [];

        foreach ($marketings as $marketing) {
            $omzet = 0;
            $komisiPersentase = 0;
            $bulan = '';

            // Hitung omzet untuk setiap marketing
            foreach ($penjualans as $penjualan) {
                if ($penjualan->marketing_id == $marketing->id) {
                    $omzet += $penjualan->grand_total;
                    $bulan = date('F', strtotime($penjualan->date));
                }
            }

            // Tentukan persentase komisi berdasarkan omzet
            $komisiPersentase = $this->calculateKomisiPersentase($omzet);

            // Tambahkan data hasil perhitungan ke dalam array
            $hasil[] = [
                'marketing' => $marketing->name,
                'bulan' => $bulan,
                'omzet' => $omzet,
                'komisi' => $komisiPersentase,
                'komisi_nominal' => $omzet * ($komisiPersentase / 100),
            ];
        }

        // Kembalikan hasil perhitungan dalam format JSON
        return response()->json($hasil);
    }

    /**
     * Menghitung persentase komisi berdasarkan omzet.
     *
     * @param float $omzet
     * @return float
     */
    private function calculateKomisiPersentase(float $omzet): float
    {
        // Tentukan persentase komisi berdasarkan batas omzet
        if ($omzet >= 500000000) {
            return 10;
        } elseif ($omzet >= 200000000) {
            return 5;
        } elseif ($omzet >= 100000000) {
            return 2.5;
        }

        return 0;
    }
}

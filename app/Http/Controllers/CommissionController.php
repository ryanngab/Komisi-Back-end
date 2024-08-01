<?php

namespace App\Http\Controllers;

use App\Models\Marketing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CommissionController extends Controller
{
    /**
     * Menghitung komisi untuk setiap marketing berdasarkan penjualan mereka.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateCommissions()
    {
        // Array untuk menyimpan hasil komisi
        $commissions = [];

        // Ambil semua marketing beserta data penjualannya
        $marketings = Marketing::with('penjualan')->get();

        foreach ($marketings as $marketing) {
            // Kelompokkan penjualan berdasarkan tahun dan bulan
            $transactions = $marketing->penjualan->groupBy(function ($sale) {
                return Carbon::parse($sale->date)->format('Y-m'); // Kelompokkan berdasarkan tahun dan bulan
            });

            foreach ($transactions as $monthYear => $sales) {
                // Ubah key kelompok menjadi nama bulan
                $monthName = Carbon::parse($monthYear . '-01')->format('F'); // Contoh: "May"
                $numericMonth = Carbon::parse($monthYear . '-01')->format('m'); // Bulan dalam format numerik

                // Hitung omzet total untuk bulan ini
                $omzet = $sales->sum('grand_total');

                // Tentukan persentase komisi berdasarkan omzet
                $commissionPercent = $this->determineCommissionPercent($omzet);

                // Hitung jumlah komisi
                $commissionAmount = $omzet * ($commissionPercent / 100);

                // Tambahkan data komisi ke array hasil
                $commissions[] = [
                    'marketing' => $marketing->name,
                    'bulan' => $monthName,
                    'bulan_angka' => $numericMonth, // Digunakan untuk sorting
                    'omzet' => number_format($omzet, 0, ',', '.'),
                    'komisi_persen' => number_format($commissionPercent, 1, ',', '.'),
                    'komisi_nominal' => number_format($commissionAmount, 0, ',', '.'),
                ];
            }
        }

        // Urutkan hasil komisi berdasarkan bulan numerik
        usort($commissions, function ($a, $b) {
            return $a['bulan_angka'] - $b['bulan_angka'];
        });

        // Hapus kolom bulan numerik dari hasil akhir
        foreach ($commissions as &$commission) {
            unset($commission['bulan_angka']);
        }

        // Kembalikan data komisi dalam format JSON
        return response()->json($commissions);
    }

    /**
     * Menentukan persentase komisi berdasarkan omzet.
     *
     * @param float $omzet
     * @return float
     */
    private function determineCommissionPercent(float $omzet): float
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

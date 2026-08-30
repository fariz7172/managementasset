<?php

namespace App\Http\Controllers;

use Ifsnop\Mysqldump as IMysqldump;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\ApiPayment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Hitung Metrik Utama
        $totalAssets = Asset::count();
        $totalApiPayments = ApiPayment::count();
        $assetProses = Asset::whereIn('status', ['Proses', 'Tertunda'])->count();
        $assetSelesai = Asset::where('status', 'Selesai')->count();

        // Ambil 5 Aktivitas Terbaru (Asset yang baru ditambah / diubah)
        $recentAssets = Asset::with(['dewan', 'kecamatan', 'kelurahan'])
                             ->orderBy('updated_at', 'desc')
                             ->take(5)
                             ->get();

        // Hitung Total Nilai Pembayaran berdasarkan filter tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = ApiPayment::query();
        if ($startDate && $endDate) {
            $query->whereDate('contract_tgl', '>=', $startDate)
                  ->whereDate('contract_tgl', '<=', $endDate);
        }
        $totalNilaiPembayaran = $query->sum('jumlah');
        $terbilangTotal = trim($totalNilaiPembayaran == 0 ? "Nol" : $this->terbilang($totalNilaiPembayaran)) . ' Rupiah';

        return view('admin.dashboard', compact(
            'totalAssets', 
            'totalApiPayments', 
            'assetProses', 
            'assetSelesai', 
            'recentAssets',
            'totalNilaiPembayaran',
            'terbilangTotal',
            'startDate',
            'endDate'
        ));
    }
    public function akses()
    {
        // Ambil data yang sudah ada di database
        $dbPayments = \App\Models\ApiPayment::all()->pluck('raw_data');
        $dewans = \App\Models\Dewan::orderBy('nama')->get();
        $kecamatans = \App\Models\Kecamatan::orderBy('nama_kecamatan')->get();
        $kelurahans = \App\Models\Kelurahan::orderBy('nama_kelurahan')->get();
        
        // Ambil ID pembayaran yang sudah diproses jadi Asset
        $processedPaymentIds = \App\Models\Asset::whereNotNull('api_payment_id')->pluck('api_payment_id')->toArray();

        return view('admin.akses', compact('dbPayments', 'dewans', 'kecamatans', 'kelurahans', 'processedPaymentIds'));
    }

    private function terbilang($angka) {
        $angka = abs($angka);
        $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $terbilang = "";
        
        if ($angka < 12) {
            $terbilang = " " . $baca[$angka];
        } else if ($angka < 20) {
            $terbilang = $this->terbilang($angka - 10) . " Belas";
        } else if ($angka < 100) {
            $terbilang = $this->terbilang((int)($angka / 10)) . " Puluh" . $this->terbilang($angka % 10);
        } else if ($angka < 200) {
            $terbilang = " Seratus" . $this->terbilang($angka - 100);
        } else if ($angka < 1000) {
            $terbilang = $this->terbilang((int)($angka / 100)) . " Ratus" . $this->terbilang($angka % 100);
        } else if ($angka < 2000) {
            $terbilang = " Seribu" . $this->terbilang($angka - 1000);
        } else if ($angka < 1000000) {
            $terbilang = $this->terbilang((int)($angka / 1000)) . " Ribu" . $this->terbilang($angka % 1000);
        } else if ($angka < 1000000000) {
            $terbilang = $this->terbilang((int)($angka / 1000000)) . " Juta" . $this->terbilang($angka % 1000000);
        } else if ($angka < 1000000000000) {
            $terbilang = $this->terbilang((int)($angka / 1000000000)) . " Milyar" . $this->terbilang(fmod($angka, 1000000000));
        } else if ($angka < 1000000000000000) {
            $terbilang = $this->terbilang((int)($angka / 1000000000000)) . " Triliun" . $this->terbilang(fmod($angka, 1000000000000));
        }
        
        return $terbilang;
    }

    public function backupDb()
    {
        try {
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $dbHost = env('DB_HOST', '127.0.0.1');

            $fileName = 'backup_' . $dbName . '_' . date('Y-m-d_H-i-s') . '.sql';
            $filePath = storage_path('app/' . $fileName);

            $dump = new IMysqldump\Mysqldump("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
            $dump->start($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal backup database: ' . $e->getMessage());
        }
    }

}

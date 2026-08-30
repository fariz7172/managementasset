<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiPayment;

class ApiPaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payments' => 'required|array',
        ]);

        $payments = $request->input('payments');

        $savedCount = 0;

        foreach ($payments as $payment) {
            ApiPayment::updateOrCreate(
                ['api_id' => $payment['id']],
                [
                    'no_spd' => $payment['no_spd'] ?? null,
                    'kode_rek' => $payment['kode_rek'] ?? null,
                    'no_spp' => $payment['no_spp'] ?? null,
                    'no_spm' => $payment['no_spm'] ?? null,
                    'no_bast' => $payment['no_bast'] ?? null,
                    'jumlah' => $payment['jumlah'] ?? null,
                    'terbilang' => $payment['terbilang'] ?? null,
                    'keperluan' => $payment['keperluan'] ?? null,
                    'denda' => $payment['denda'] ?? null,
                    'vendor_nama' => isset($payment['vendor']['nama_perusahaan']) ? $payment['vendor']['nama_perusahaan'] : null,
                    'vendor_npwp' => isset($payment['vendor']['npwp']) ? $payment['vendor']['npwp'] : null,
                    'contract_nomor' => isset($payment['contract']['nomor_kontrak']) ? $payment['contract']['nomor_kontrak'] : null,
                    'contract_tgl' => isset($payment['contract']['tgl_kontrak']) ? date('Y-m-d', strtotime($payment['contract']['tgl_kontrak'])) : null,
                    'raw_data' => $payment,
                ]
            );
            $savedCount++;
        }

        return response()->json([
            'status' => 'success', 
            'message' => "Successfully synchronized $savedCount records."
        ]);
    }
}

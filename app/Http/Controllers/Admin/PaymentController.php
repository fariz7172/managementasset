<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = [];
        $error = null;

        try {
            // Using a timeout of 10s. Since the user did not provide a token, we don't send one.
            $response = Http::timeout(10)->get('https://aplikasimailingsudin.farizahmad.com/api/payments');

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data']) && is_array($data['data'])) {
                    $payments = $data['data'];
                }
            } else {
                $error = 'Gagal mengambil data dari server API Payments. HTTP Status: ' . $response->status();
            }
        } catch (\Exception $e) {
            $error = 'Terjadi kesalahan saat menghubungi API Payments: ' . $e->getMessage();
        }

        // Pagination
        $collection = collect($payments);
        $perPage = 15;
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $paginatedPayments = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems, 
            $collection->count(), 
            $perPage, 
            $currentPage,
            ['path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('admin.payments.index', ['payments' => $paginatedPayments, 'error' => $error, 'total_data' => count($payments)]);
    }
}

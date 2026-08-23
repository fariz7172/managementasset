<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MonitoringResesController extends Controller
{
    public function index()
    {
        $locations = [];
        $error = null;
        $totalReses = 0;
        $totalMasyarakat = 0;

        try {
            $response = Http::withToken('1|NOOazE9wfjBcGD7pt850sGuQ9gXC4HyURp8X6b2W3b61246b')
                ->timeout(10) // 10 seconds timeout
                ->get('https://app-reses.farizahmad.com/api/pekerjaan-sda/map');

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data']) && is_array($data['data'])) {
                    foreach ($data['data'] as $item) {
                        if (!empty($item['latitude']) && !empty($item['longitude'])) {
                            
                            $progress = (int) ($item['progress'] ?? 0);
                            $sumberData = trim($item['sumber_data'] ?? '');
                            
                            // Count totals based on sumber_data
                            if (strcasecmp($sumberData, 'Reses') === 0) {
                                $totalReses++;
                            } elseif (strcasecmp($sumberData, 'Masyarakat') === 0) {
                                $totalMasyarakat++;
                            }
                            
                            // Determine status & color based on requirements
                            if ($progress >= 100) {
                                $status = 'Selesai';
                                $color = '#10b981'; // Green overrides everything if 100%
                            } else {
                                // Set status text
                                $status = $progress > 0 ? 'Dalam Pengerjaan' : 'Belum Dikerjakan';
                                
                                // Set color based on sumber_data
                                if (strcasecmp($sumberData, 'Reses') === 0) {
                                    $color = '#3b82f6'; // Blue for Reses
                                } elseif (strcasecmp($sumberData, 'Masyarakat') === 0) {
                                    $color = '#f97316'; // Orange for Masyarakat
                                } else {
                                    $color = '#ef4444'; // Red default for others
                                }
                            }

                            $locations[] = [
                                'id' => 'reses_' . $item['id'],
                                'name' => $item['alamat'] ?: 'Pekerjaan SDA ' . $item['id'],
                                'no_skpd' => $item['no_skpd'] ?? '-',
                                'deskripsi' => $item['deskripsi'] ?? 'Tidak ada deskripsi',
                                'sumber_data' => $sumberData ?: '-',
                                'status_tindak_lanjut' => $item['status_tindak_lanjut'] ?? '-',
                                'progress' => $progress,
                                'type' => 'Pekerjaan SDA',
                                'lat' => (float) $item['latitude'],
                                'lng' => (float) $item['longitude'],
                                'status' => $status,
                                'color' => $color,
                                'search_text' => strtolower(($item['alamat'] ?? '') . ' ' . ($item['deskripsi'] ?? '') . ' ' . ($item['no_skpd'] ?? '')),
                            ];
                        }
                    }
                }
            } else {
                $error = 'Gagal mengambil data dari server API RESES. HTTP Status: ' . $response->status();
            }
        } catch (\Exception $e) {
            $error = 'Terjadi kesalahan saat menghubungi API RESES: ' . $e->getMessage();
        }

        return view('admin.monitoring.reses', compact('locations', 'error', 'totalReses', 'totalMasyarakat'));
    }

    public function publicMap()
    {
        $locations = [];
        $error = null;
        $totalReses = 0;
        $totalMasyarakat = 0;

        try {
            $response = Http::withToken('1|NOOazE9wfjBcGD7pt850sGuQ9gXC4HyURp8X6b2W3b61246b')
                ->timeout(10) // 10 seconds timeout
                ->get('https://app-reses.farizahmad.com/api/pekerjaan-sda/map');

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data']) && is_array($data['data'])) {
                    foreach ($data['data'] as $item) {
                        if (!empty($item['latitude']) && !empty($item['longitude'])) {
                            
                            $progress = (int) ($item['progress'] ?? 0);
                            $sumberData = trim($item['sumber_data'] ?? '');
                            
                            // Count totals based on sumber_data
                            if (strcasecmp($sumberData, 'Reses') === 0) {
                                $totalReses++;
                            } elseif (strcasecmp($sumberData, 'Masyarakat') === 0) {
                                $totalMasyarakat++;
                            }
                            
                            // Determine status & color based on requirements
                            if ($progress >= 100) {
                                $status = 'Selesai';
                                $color = '#10b981'; // Green overrides everything if 100%
                            } else {
                                // Set status text
                                $status = $progress > 0 ? 'Dalam Pengerjaan' : 'Belum Dikerjakan';
                                
                                // Set color based on sumber_data
                                if (strcasecmp($sumberData, 'Reses') === 0) {
                                    $color = '#3b82f6'; // Blue for Reses
                                } elseif (strcasecmp($sumberData, 'Masyarakat') === 0) {
                                    $color = '#f97316'; // Orange for Masyarakat
                                } else {
                                    $color = '#ef4444'; // Red default for others
                                }
                            }

                            $locations[] = [
                                'id' => 'reses_' . $item['id'],
                                'name' => $item['alamat'] ?: 'Pekerjaan SDA ' . $item['id'],
                                'no_skpd' => $item['no_skpd'] ?? '-',
                                'deskripsi' => $item['deskripsi'] ?? 'Tidak ada deskripsi',
                                'sumber_data' => $sumberData ?: '-',
                                'status_tindak_lanjut' => $item['status_tindak_lanjut'] ?? '-',
                                'progress' => $progress,
                                'type' => 'Pekerjaan SDA',
                                'lat' => (float) $item['latitude'],
                                'lng' => (float) $item['longitude'],
                                'status' => $status,
                                'color' => $color,
                                'search_text' => strtolower(($item['alamat'] ?? '') . ' ' . ($item['deskripsi'] ?? '') . ' ' . ($item['no_skpd'] ?? '')),
                            ];
                        }
                    }
                }
            } else {
                $error = 'Gagal mengambil data dari server API RESES. HTTP Status: ' . $response->status();
            }
        } catch (\Exception $e) {
            $error = 'Terjadi kesalahan saat menghubungi API RESES: ' . $e->getMessage();
        }

        return view('public.map-reses', compact('locations', 'error', 'totalReses', 'totalMasyarakat'));
    }
}

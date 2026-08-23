<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PintuAir;
use App\Models\Pompa;
use App\Models\PompaMobile;
use App\Models\SubPolder;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        $locations = [];

        // Pintu Air (Biru)
        $pintuAirs = PintuAir::whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($pintuAirs as $p) {
            $isPerbaikan = ($p->status == '0' || strtolower($p->status) == 'rusak' || strtolower($p->status) == 'dalam perbaikan');
            $locations[] = [
                'id' => 'pintuair_' . $p->id,
                'name' => $p->nama,
                'type' => 'Pintu Air',
                'lat' => (float) $p->latitude,
                'lng' => (float) $p->longitude,
                'status' => $isPerbaikan ? 'Perbaikan' : 'Aktif',
                'color' => $isPerbaikan ? '#ef4444' : '#3b82f6', // red if broken, blue if active
                'search_text' => strtolower($p->nama),
            ];
        }

        // Pompa (Orange)
        $pompas = Pompa::whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($pompas as $p) {
            $isPerbaikan = ($p->status == '0' || strtolower($p->status) == 'rusak' || strtolower($p->status) == 'dalam perbaikan');
            $locations[] = [
                'id' => 'pompa_' . $p->id,
                'name' => $p->nama,
                'type' => 'Pompa',
                'lat' => (float) $p->latitude,
                'lng' => (float) $p->longitude,
                'status' => $isPerbaikan ? 'Perbaikan' : 'Aktif',
                'color' => $isPerbaikan ? '#ef4444' : '#f97316', // red if broken, orange if active
                'search_text' => strtolower($p->nama),
            ];
        }

        // Pompa Mobile (Hijau)
        $pompaMobiles = PompaMobile::whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($pompaMobiles as $p) {
            $isPerbaikan = ($p->status == '0' || strtolower($p->status) == 'rusak' || strtolower($p->status) == 'dalam perbaikan');
            $locations[] = [
                'id' => 'pompamobile_' . $p->id,
                'name' => $p->no_seri_plat ?: 'Pompa Mobile ' . $p->id,
                'type' => 'Pompa Mobile',
                'lat' => (float) $p->latitude,
                'lng' => (float) $p->longitude,
                'status' => $isPerbaikan ? 'Perbaikan' : 'Aktif',
                'color' => $isPerbaikan ? '#ef4444' : '#10b981', // red if broken, green if active
                'search_text' => strtolower(($p->no_seri_plat ?? '') . ' ' . ($p->lokasi ?? '')),
            ];
        }

        // Sub Polder (Pink)
        $subPolders = SubPolder::whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($subPolders as $p) {
            $isPerbaikan = ($p->status == '0' || strtolower($p->status) == 'rusak' || strtolower($p->status) == 'dalam perbaikan');
            $locations[] = [
                'id' => 'subpolder_' . $p->id,
                'name' => $p->nama_lokasi,
                'type' => 'Sub Polder',
                'lat' => (float) $p->latitude,
                'lng' => (float) $p->longitude,
                'status' => $isPerbaikan ? 'Perbaikan' : 'Aktif',
                'color' => $isPerbaikan ? '#ef4444' : '#ec4899', // red if broken, pink if active
                'search_text' => strtolower(($p->nama_lokasi ?? '') . ' ' . ($p->jenis_pompa ?? '') . ' ' . ($p->merk_pompa ?? '') . ' ' . ($p->alamat ?? '')),
            ];
        }

        return view('admin.monitoring.index', compact('locations'));
    }

    public function publicMap()
    {
        // We can reuse the exact same logic for fetching locations
        // To avoid code duplication, we can extract it or just call index() logic.
        // For simplicity, we just copy the data preparation from index.
        $locations = [];

        // Pintu Air
        $pintuAirs = PintuAir::whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($pintuAirs as $p) {
            $isPerbaikan = ($p->status == '0' || strtolower($p->status) == 'rusak' || strtolower($p->status) == 'dalam perbaikan');
            $locations[] = [
                'id' => 'pintuair_' . $p->id,
                'name' => $p->nama,
                'type' => 'Pintu Air',
                'lat' => (float) $p->latitude,
                'lng' => (float) $p->longitude,
                'status' => $isPerbaikan ? 'Perbaikan' : 'Aktif',
                'color' => $isPerbaikan ? '#ef4444' : '#3b82f6',
                'search_text' => strtolower($p->nama),
            ];
        }

        // Pompa
        $pompas = Pompa::whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($pompas as $p) {
            $isPerbaikan = ($p->status == '0' || strtolower($p->status) == 'rusak' || strtolower($p->status) == 'dalam perbaikan');
            $locations[] = [
                'id' => 'pompa_' . $p->id,
                'name' => $p->nama,
                'type' => 'Pompa',
                'lat' => (float) $p->latitude,
                'lng' => (float) $p->longitude,
                'status' => $isPerbaikan ? 'Perbaikan' : 'Aktif',
                'color' => $isPerbaikan ? '#ef4444' : '#f97316',
                'search_text' => strtolower($p->nama),
            ];
        }

        // Pompa Mobile
        $pompaMobiles = PompaMobile::whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($pompaMobiles as $p) {
            $isPerbaikan = ($p->status == '0' || strtolower($p->status) == 'rusak' || strtolower($p->status) == 'dalam perbaikan');
            $locations[] = [
                'id' => 'pompamobile_' . $p->id,
                'name' => $p->no_seri_plat ?: 'Pompa Mobile ' . $p->id,
                'type' => 'Pompa Mobile',
                'lat' => (float) $p->latitude,
                'lng' => (float) $p->longitude,
                'status' => $isPerbaikan ? 'Perbaikan' : 'Aktif',
                'color' => $isPerbaikan ? '#ef4444' : '#10b981',
                'search_text' => strtolower(($p->no_seri_plat ?? '') . ' ' . ($p->lokasi ?? '')),
            ];
        }

        // Sub Polder
        $subPolders = SubPolder::whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($subPolders as $p) {
            $isPerbaikan = ($p->status == '0' || strtolower($p->status) == 'rusak' || strtolower($p->status) == 'dalam perbaikan');
            $locations[] = [
                'id' => 'subpolder_' . $p->id,
                'name' => $p->nama_lokasi,
                'type' => 'Sub Polder',
                'lat' => (float) $p->latitude,
                'lng' => (float) $p->longitude,
                'status' => $isPerbaikan ? 'Perbaikan' : 'Aktif',
                'color' => $isPerbaikan ? '#ef4444' : '#ec4899',
                'search_text' => strtolower(($p->nama_lokasi ?? '') . ' ' . ($p->jenis_pompa ?? '') . ' ' . ($p->merk_pompa ?? '') . ' ' . ($p->alamat ?? '')),
            ];
        }

        return view('public.map', compact('locations'));
    }
}

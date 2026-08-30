<?php

namespace App\Http\Controllers;

use App\Models\PendataanSensus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PendataanSensusController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = PendataanSensus::latest('id');

        if ($request->has('kecamatan') && $request->kecamatan != '') {
            $query->where('kecamatan', $request->kecamatan);
        }
        
        if ($request->has('status_pelaksanaan') && $request->status_pelaksanaan != '') {
            $query->where('status_pelaksanaan', $request->status_pelaksanaan);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_objek', 'like', "%{$search}%");
            });
        }

        $sensuses = $query->paginate(15)->withQueryString();
        $kecamatans = PendataanSensus::select('kecamatan')->distinct()->whereNotNull('kecamatan')->orderBy('kecamatan')->pluck('kecamatan');
        $statusPelaksanaans = PendataanSensus::select('status_pelaksanaan')->distinct()->whereNotNull('status_pelaksanaan')->orderBy('status_pelaksanaan')->pluck('status_pelaksanaan');

        return view('admin.sensus.index', compact('sensuses', 'kecamatans', 'statusPelaksanaans'));
    }

    public function exportPdf(\Illuminate\Http\Request $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '300');
        
        $query = PendataanSensus::latest('id');

        if ($request->has('kecamatan') && $request->kecamatan != '') {
            $query->where('kecamatan', $request->kecamatan);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_objek', 'like', "%{$search}%");
            });
        }

        $sensuses = $query->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.sensus.pdf', compact('sensuses'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('data-sensus.pdf');
    }

    public function create()
    {
        return view('admin.sensus.create');
    }

    private function processAndSavePhotos($request, $existingPhotos = [])
    {
        $photos = $existingPhotos ?? [];

        if ($request->hasFile('url_foto_pendataan')) {
            foreach ($request->file('url_foto_pendataan') as $file) {
                // Generate a unique filename with .webp extension
                $filename = Str::random(40) . '.webp';
                $path = 'sensus_photos/' . $filename;
                $fullPath = storage_path('app/public/' . $path);

                // Create directory if it doesn't exist
                if (!file_exists(storage_path('app/public/sensus_photos'))) {
                    mkdir(storage_path('app/public/sensus_photos'), 0755, true);
                }

                $imagePath = $file->getRealPath();
                $mimeType = $file->getMimeType();

                // Convert to WebP using GD
                $image = null;
                switch ($mimeType) {
                    case 'image/jpeg':
                        $image = @imagecreatefromjpeg($imagePath);
                        break;
                    case 'image/png':
                        $image = @imagecreatefrompng($imagePath);
                        if ($image) {
                            imagepalettetotruecolor($image);
                            imagealphablending($image, true);
                            imagesavealpha($image, true);
                        }
                        break;
                    case 'image/webp':
                        $image = @imagecreatefromwebp($imagePath);
                        break;
                }

                if ($image) {
                    // Save as WebP with 80% quality
                    imagewebp($image, $fullPath, 80);
                    imagedestroy($image);
                    $photos[] = $path;
                }
            }
        }

        return $photos;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'nullable|string',
            'nama_barang' => 'nullable|string',
            'nomor_register' => 'nullable|string',
            'tanggal_perolehan' => 'nullable|date',
            'harga' => 'nullable|numeric',
            'objek' => 'nullable|string',
            'nama_objek' => 'nullable|string',
            'sub_rincian_objek' => 'nullable|string',
            'nama_sub_rincian_objek' => 'nullable|string',
            'panjang' => 'nullable|numeric',
            'lebar' => 'nullable|numeric',
            'ukuran' => 'nullable|string',
            'satuan' => 'nullable|string',
            'nama_jalan_alamat' => 'nullable|string',
            'nomor_jalan' => 'nullable|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'kode_kelurahan' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'penggunaan' => 'nullable|string',
            'ket_masalah' => 'nullable|string',
            'pengembang' => 'nullable|string',
            'url_foto_pendataan.*' => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:5120',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'alamat_foto_pendataan' => 'nullable|string',
            'jenis_objek_kib_d' => 'nullable|string',
            'dibuat_diperbaharui_pada' => 'nullable|date',
            'dibuat_diperbaharui_oleh' => 'nullable|string',
        ]);

        $photos = $this->processAndSavePhotos($request);
        $validated['url_foto_pendataan'] = empty($photos) ? null : $photos;

        PendataanSensus::create($validated);

        return redirect()->route('sensus.index')->with('success', 'Data sensus berhasil ditambahkan');
    }



    public function show(PendataanSensus $sensus)
    {
        return view('admin.sensus.show', compact('sensus'));
    }

    public function edit(PendataanSensus $sensus)
    {
        return view('admin.sensus.edit', compact('sensus'));
    }

    public function update(Request $request, PendataanSensus $sensus)
    {
        $validated = $request->validate([
            'kode_barang' => 'nullable|string',
            'nama_barang' => 'nullable|string',
            'nomor_register' => 'nullable|string',
            'tanggal_perolehan' => 'nullable|date',
            'harga' => 'nullable|numeric',
            'objek' => 'nullable|string',
            'nama_objek' => 'nullable|string',
            'sub_rincian_objek' => 'nullable|string',
            'nama_sub_rincian_objek' => 'nullable|string',
            'panjang' => 'nullable|numeric',
            'lebar' => 'nullable|numeric',
            'ukuran' => 'nullable|string',
            'satuan' => 'nullable|string',
            'nama_jalan_alamat' => 'nullable|string',
            'nomor_jalan' => 'nullable|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'kode_kelurahan' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'penggunaan' => 'nullable|string',
            'ket_masalah' => 'nullable|string',
            'pengembang' => 'nullable|string',
            'url_foto_pendataan.*' => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:5120',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'alamat_foto_pendataan' => 'nullable|string',
            'jenis_objek_kib_d' => 'nullable|string',
            'dibuat_diperbaharui_pada' => 'nullable|date',
            'dibuat_diperbaharui_oleh' => 'nullable|string',
        ]);

        // If user uploads new photos, we append them to the old ones
        if ($request->hasFile('url_foto_pendataan')) {
            // Retrieve old photos
            $oldPhotos = is_array($sensus->url_foto_pendataan) ? $sensus->url_foto_pendataan : [];
            
            // Process and save new photos
            $newPhotos = $this->processAndSavePhotos($request);
            
            // Merge old and new photos
            $allPhotos = array_merge($oldPhotos, $newPhotos);
            $validated['url_foto_pendataan'] = empty($allPhotos) ? null : $allPhotos;
        } else {
            // Keep old photos if nothing new is uploaded
            unset($validated['url_foto_pendataan']);
        }

        $sensus->update($validated);

        return redirect()->route('sensus.index')->with('success', 'Data sensus berhasil diperbarui');
    }

    public function destroy(PendataanSensus $sensus)
    {
        if (is_array($sensus->url_foto_pendataan)) {
            foreach ($sensus->url_foto_pendataan as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }
        $sensus->delete();
        return redirect()->route('sensus.index')->with('success', 'Data sensus berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls|max:51200'
        ]);

        $file = $request->file('file_excel');
        
        if ($xlsx = \Shuchkin\SimpleXLSX::parse($file->getRealPath())) {
            $rows = $xlsx->rows();
            if (count($rows) <= 1) {
                return back()->withErrors(['file_excel' => 'File Excel kosong atau tidak memiliki data.']);
            }

            // Remove header
            array_shift($rows);
            
            $model = new PendataanSensus();
            $fillables = $model->getFillable();

            $insertData = [];
            
            foreach ($rows as $row) {
                $rowData = [];
                // Asumsi: urutan kolom Excel sama persis dengan urutan array $fillable
                foreach ($fillables as $index => $field) {
                    $val = isset($row[$index]) ? $row[$index] : null;
                    
                    if (is_string($val)) {
                        $val = trim($val);
                    }
                    if ($val === '') {
                        $val = null;
                    }

                    // Khusus kolom foto, dibungkus menjadi array JSON
                    if ($field === 'url_foto_pendataan' && $val !== null) {
                        $rowData[$field] = json_encode([$val]);
                    } 
                    // Penyesuaian format tanggal
                    else if (in_array($field, ['tanggal_perolehan', 'tanggal_dokumen', 'dibuat_diperbaharui_pada']) && $val !== null) {
                        try {
                            $rowData[$field] = \Carbon\Carbon::parse($val)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $rowData[$field] = null; // Abaikan jika gagal parse
                        }
                    } 
                    else {
                        $rowData[$field] = $val;
                    }
                }

                // [REQ] Override data latitude dan longitude dari kolom DV (125) dan DW (126)
                if (!empty($row[125])) {
                    $latStr = trim($row[125]);
                    $rowData['latitude'] = str_replace(',', '.', $latStr);
                }
                if (!empty($row[126])) {
                    $lngStr = trim($row[126]);
                    $rowData['longitude'] = str_replace(',', '.', $lngStr);
                }
                
                $rowData['created_at'] = now();
                $rowData['updated_at'] = now();

                $insertData[] = $rowData;
                
                // Chunk insert setiap 200 baris agar tidak melebihi limit placeholder MySQL
                if (count($insertData) >= 200) {
                    PendataanSensus::insert($insertData);
                    $insertData = [];
                }
            }

            // Insert sisa data
            if (count($insertData) > 0) {
                PendataanSensus::insert($insertData);
            }

            return back()->with('success', 'Data Excel berhasil diimport!');
        } else {
            return back()->withErrors(['file_excel' => \Shuchkin\SimpleXLSX::parseError()]);
        }
    }
}

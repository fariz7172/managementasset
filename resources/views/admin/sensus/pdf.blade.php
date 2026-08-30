<!DOCTYPE html>
<html>
<head>
    <title>Data Sensus</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f4f4f4; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; margin-top: 0; color: #555; }
    </style>
</head>
<body>
    <h2>Laporan Data Sensus</h2>
    <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
                <th>Tanggal Perolehan</th>
                <th>Harga</th>
                <th>Alamat / Jalan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sensuses as $index => $sensus)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $sensus->kode_barang }}</td>
                <td>{{ $sensus->nama_barang }}</td>
                <td>{{ $sensus->kecamatan }}</td>
                <td>{{ $sensus->kelurahan }}</td>
                <td>{{ $sensus->tanggal_perolehan }}</td>
                <td>Rp {{ number_format($sensus->harga, 0, ',', '.') }}</td>
                <td>{{ $sensus->nama_jalan_alamat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
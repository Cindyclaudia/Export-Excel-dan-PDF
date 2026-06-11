<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Data Jurusan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        thead th {
            background: #1a1a2e; color: #fff;
            padding: 10px; text-align: left; font-size: 13px;
        }
        tbody td { padding: 9px 10px; border-bottom: 1px solid #eee; }
        tbody tr:nth-child(even) { background: #f9f9f9; }
        .badge {
            padding: 3px 10px; border-radius: 10px;
            font-size: 12px; font-weight: bold;
        }
        .badge-a { background: #d4edda; color: #155724; }
        .badge-b { background: #cce5ff; color: #004085; }
        .badge-c { background: #fff3cd; color: #856404; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; color: #888; }
        .btn-print {
            background: #1a1a2e; color: #fff; border: none;
            padding: 8px 20px; border-radius: 8px; cursor: pointer;
            font-size: 13px; margin-bottom: 15px;
        }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">🖨️ Print / Save as PDF</button>

    <div class="header">
        <h2>Data Jurusan</h2>
        <p>Universitas Teknologi Bandung</p>
        <p>Tanggal: {{ date('d-m-Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jurusan</th>
                <th>Akreditasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jurusans as $index => $jurusan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $jurusan->nama_jurusan }}</td>
                <td>
                    <span class="badge {{ $jurusan->akreditasi == 'A' ? 'badge-a' : ($jurusan->akreditasi == 'B' ? 'badge-b' : 'badge-c') }}">
                        Akreditasi {{ $jurusan->akreditasi }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total: {{ $jurusans->count() }} Jurusan
    </div>
</body>
</html>
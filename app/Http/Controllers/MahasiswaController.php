<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with('jurusan')->get();
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('mahasiswa.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim'        => 'required|unique:mahasiswas,nim',
            'nama'       => 'required',
            'id_jurusan' => 'required',
        ]);

        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $jurusans = Jurusan::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'jurusans'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nim'        => 'required|unique:mahasiswas,nim,' . $mahasiswa->id_mahasiswa . ',id_mahasiswa',
            'nama'       => 'required',
            'id_jurusan' => 'required',
        ]);

        $mahasiswa->update($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diupdate!');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus!');
    }

    public function print()
    {
        $mahasiswas = Mahasiswa::with('jurusan')->get();
        $html = '
        <html><head><style>
        body{font-family:Arial;font-size:13px;}
        h2{text-align:center;}
        p{text-align:center;color:#555;}
        table{width:100%;border-collapse:collapse;margin-top:15px;}
        th{background:#1a1a2e;color:#fff;padding:10px;text-align:left;}
        td{padding:9px 10px;border-bottom:1px solid #eee;}
        tr:nth-child(even){background:#f9f9f9;}
        .btn{background:#1a1a2e;color:#fff;border:none;padding:8px 20px;border-radius:8px;cursor:pointer;margin-bottom:15px;}
        @media print{.btn{display:none;}}
        </style></head><body>
        <button class="btn" onclick="window.print()">🖨️ Print / Save as PDF</button>
        <h2>Data Mahasiswa</h2>
        <p>Universitas Teknologi Bandung</p>
        <p>Tanggal: ' . date('d-m-Y') . '</p>
        <table>
        <thead><tr><th>No</th><th>NIM</th><th>Nama</th><th>Jurusan</th></tr></thead>
        <tbody>';
        foreach ($mahasiswas as $i => $m) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $m->nim . '</td>
                <td>' . $m->nama . '</td>
                <td>' . ($m->jurusan->nama_jurusan ?? '-') . '</td>
            </tr>';
        }
        $html .= '</tbody></table>
        <p style="text-align:right;margin-top:20px;color:#888;">Total: ' . $mahasiswas->count() . ' Mahasiswa</p>
        </body></html>';
        return response($html);
    }

    public function exportExcel()
    {
        $mahasiswas = Mahasiswa::with('jurusan')->get();
        $html = '<table>
            <thead><tr><th>No</th><th>NIM</th><th>Nama</th><th>Jurusan</th></tr></thead>
            <tbody>';
        foreach ($mahasiswas as $i => $m) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $m->nim . '</td>
                <td>' . $m->nama . '</td>
                <td>' . ($m->jurusan->nama_jurusan ?? '-') . '</td>
            </tr>';
        }
        $html .= '</tbody></table>';
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename=mahasiswa.xls');
    }

    public function exportCsv()
    {
        $mahasiswas = Mahasiswa::with('jurusan')->get();
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename=mahasiswa.csv',
        ];
        $callback = function () use ($mahasiswas) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['No', 'NIM', 'Nama', 'Jurusan'], ';');
            foreach ($mahasiswas as $i => $m) {
                fputcsv($file, [
                    $i + 1,
                    $m->nim,
                    $m->nama,
                    $m->jurusan->nama_jurusan ?? '-',
                ], ';');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
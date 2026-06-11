<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliahs = Matakuliah::with('jurusan')->get();
        return view('matakuliah.index', compact('matakuliahs'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('matakuliah.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_matakuliah' => 'required',
            'sks' => 'required|integer',
            'id_jurusan' => 'required',
        ]);
        Matakuliah::create($request->all());
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil ditambahkan!');
    }

    public function edit(Matakuliah $matakuliah)
    {
        $jurusans = Jurusan::all();
        return view('matakuliah.edit', compact('matakuliah', 'jurusans'));
    }

    public function update(Request $request, Matakuliah $matakuliah)
    {
        $request->validate([
            'nama_matakuliah' => 'required',
            'sks' => 'required|integer',
            'id_jurusan' => 'required',
        ]);
        $matakuliah->update($request->all());
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil diupdate!');
    }

    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil dihapus!');
    }

    public function print()
    {
        $matakuliahs = Matakuliah::with('jurusan')->get();
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
        <h2>Data Matakuliah</h2>
        <p>Universitas Teknologi Bandung</p>
        <p>Tanggal: ' . date('d-m-Y') . '</p>
        <table>
        <thead><tr><th>No</th><th>Nama Matakuliah</th><th>SKS</th><th>Jurusan</th></tr></thead>
        <tbody>';
        foreach ($matakuliahs as $i => $m) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $m->nama_matakuliah . '</td>
                <td>' . $m->sks . ' SKS</td>
                <td>' . ($m->jurusan->nama_jurusan ?? '-') . '</td>
            </tr>';
        }
        $html .= '</tbody></table>
        <p style="text-align:right;margin-top:20px;color:#888;">Total: ' . $matakuliahs->count() . ' Matakuliah</p>
        </body></html>';
        return response($html);
    }

    public function exportExcel()
    {
        $matakuliahs = Matakuliah::with('jurusan')->get();
        $html = '<table>
            <thead><tr><th>No</th><th>Nama Matakuliah</th><th>SKS</th><th>Jurusan</th></tr></thead>
            <tbody>';
        foreach ($matakuliahs as $i => $m) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $m->nama_matakuliah . '</td>
                <td>' . $m->sks . '</td>
                <td>' . ($m->jurusan->nama_jurusan ?? '-') . '</td>
            </tr>';
        }
        $html .= '</tbody></table>';
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename=matakuliah.xls');
    }
}
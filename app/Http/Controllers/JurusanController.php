<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::all();
        return view('jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required',
            'akreditasi' => 'required',
        ]);
        Jurusan::create($request->all());
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required',
            'akreditasi' => 'required',
        ]);
        $jurusan->update($request->all());
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diupdate!');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus!');
    }

    public function print()
    {
        $jurusans = Jurusan::all();
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
        <h2>Data Jurusan</h2>
        <p>Universitas Teknologi Bandung</p>
        <p>Tanggal: ' . date('d-m-Y') . '</p>
        <table>
        <thead><tr><th>No</th><th>Nama Jurusan</th><th>Akreditasi</th></tr></thead>
        <tbody>';
        foreach ($jurusans as $i => $j) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $j->nama_jurusan . '</td>
                <td>' . $j->akreditasi . '</td>
            </tr>';
        }
        $html .= '</tbody></table>
        <p style="text-align:right;margin-top:20px;color:#888;">Total: ' . $jurusans->count() . ' Jurusan</p>
        </body></html>';
        return response($html);
    }

    public function exportExcel()
    {
        $jurusans = Jurusan::all();
        $html = '<table>
            <thead><tr><th>No</th><th>Nama Jurusan</th><th>Akreditasi</th></tr></thead>
            <tbody>';
        foreach ($jurusans as $i => $j) {
            $html .= '<tr>
                <td>' . ($i + 1) . '</td>
                <td>' . $j->nama_jurusan . '</td>
                <td>' . $j->akreditasi . '</td>
            </tr>';
        }
        $html .= '</tbody></table>';
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename=jurusan.xls');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function handleMahasiswaRoot(Request $request)
    {
        if ($request->isMethod('post') || $request->has('nim') || $request->has('nama')) {
            return $this->store($request);
        }
        return $this->index();
    }

    // 🔥 FIX UTAMA: INDEX DIUBAH JADI VIEW (bukan JSON)
    public function index()
    {
        try {
            $mahasiswas = Mahasiswa::all();

            $result = $mahasiswas->map(function ($mahasiswa) {

                $jurusan = DB::table('jurusans')
                    ->where('id_jurusan', $mahasiswa->id_jurusan)
                    ->first();

                if (!$jurusan) {
                    $detailJurusan = [
                        'id_jurusan'   => (int)$mahasiswa->id_jurusan,
                        'nama_jurusan' => $mahasiswa->id_jurusan == 2 ? 'Sistem Informasi' : 'Teknik Informatika',
                        'akreditasi'   => 'A',
                    ];
                } else {
                    $detailJurusan = [
                        'id_jurusan'   => (int)$jurusan->id_jurusan,
                        'nama_jurusan' => $jurusan->nama_jurusan,
                        'akreditasi'   => $jurusan->akreditasi,
                    ];
                }

                return (object)[
                    'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                    'nim' => $mahasiswa->nim,
                    'nama' => $mahasiswa->nama,
                    'email' => $mahasiswa->email,
                    'detail_jurusan' => (object)$detailJurusan
                ];
            });

            // ✅ INI YANG DIUBAH (dari JSON → VIEW)
            return view('mahasiswa.index', [
                'mahasiswa' => $result
            ]);

        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }

    // SHOW (TETAP)
    public function show($id)
    {
        $mahasiswa = Mahasiswa::where('id_mahasiswa', $id)->first();

        if (!$mahasiswa) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'result' => $mahasiswa
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim'        => 'required|unique:mahasiswa,nim',
            'nama'       => 'required',
            'id_jurusan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Validasi gagal',
                'error' => $validator->errors()->first()
            ], 400);
        }

        $mahasiswa = Mahasiswa::create($request->all());

        return response()->json([
            'status'  => 201,
            'success' => true,
            'message' => 'Mahasiswa berhasil ditambahkan!',
            'result'  => $mahasiswa
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::where('id_mahasiswa', $id)->first();

        if (!$mahasiswa) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $mahasiswa->update($request->all());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'result' => $mahasiswa
        ], 200);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::where('id_mahasiswa', $id)->first();

        if (!$mahasiswa) {
            return response()->json([
                'status' => 404,
                'success' => false
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ], 200);
    }

    public function create()
    {
        return view('mahasiswa.create', [
            'jurusans' => Jurusan::all()
        ]);
    }

    public function edit($id)
    {
        return view('mahasiswa.edit', [
            'mahasiswa' => Mahasiswa::where('id_mahasiswa', $id)->first(),
            'jurusans' => Jurusan::all()
        ]);
    }

    public function exportCsv()
    {
        $fileName = 'mahasiswa.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'ID',
                'NIM',
                'Nama',
                'Jurusan'
            ], ';');

            $mahasiswa = Mahasiswa::with('detail_jurusan')->get();

            foreach ($mahasiswa as $item) {

                fputcsv($file, [
                    $item->id_mahasiswa,
                    $item->nim,
                    $item->nama,
                    $item->detail_jurusan->nama_jurusan ?? '-',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function print()
    {
        $mahasiswa = Mahasiswa::with('detail_jurusan')->get();

        return view('mahasiswa.print', compact('mahasiswa'));
    }

    public function exportExcel()
    {
        $mahasiswa = Mahasiswa::with('detail_jurusan')->get();

        return response()
            ->view('mahasiswa.excel', compact('mahasiswa'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename=mahasiswa.xls');
    }
}
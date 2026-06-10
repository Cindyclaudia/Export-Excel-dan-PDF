<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Validator;

class MahasiswaApi extends Controller
{
    // 1. TAMPIL SEMUA DATA (GET)
    public function index()
    {
        $mahasiswa = Mahasiswa::all();

        if($mahasiswa->isEmpty()) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Data mahasiswa berhasil diambil',
            'result' => $mahasiswa
        ], 200);
    }

    // 2. TAMPIL BERDASARKAN ID (GET)
    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if(!$mahasiswa){
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'result' => $mahasiswa
        ], 200);
    }

    // 3. TAMBAH DATA (POST)
    public function store(Request $request)
    {
        // Validasi input data dari Postman
        $validator = Validator::make($request->all(), [
            'nim'        => 'required',
            'nama'       => 'required',
            'email'      => 'required|email',
            'id_jurusan' => 'required',
        ]);

        // Jika data di Postman tidak lengkap/salah format emailnya
        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'success' => false,
                'message' => 'Validasi gagal, data tidak lengkap atau salah format',
                'errors'  => $validator->errors()
            ], 400);
        }

        // Simpan data secara manual ke database agar aman dari masalah cache primary key ganda
        $mahasiswa = new Mahasiswa();
        $mahasiswa->nim        = $request->nim;
        $mahasiswa->nama       = $request->nama;
        $mahasiswa->email      = $request->email;
        $mahasiswa->id_jurusan = $request->id_jurusan;
        $mahasiswa->save();

        return response()->json([
            'status'  => 201,
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'result'  => $mahasiswa
        ], 201);
    }

    // 4. UPDATE DATA (PUT/PATCH)
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if(!$mahasiswa){
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Update data secara manual sesuai request baru
        $mahasiswa->nim        = $request->nim;
        $mahasiswa->nama       = $request->nama;
        $mahasiswa->email      = $request->email;
        $mahasiswa->id_jurusan = $request->id_jurusan;
        $mahasiswa->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Data berhasil diupdate'
        ], 200);
    }

    // 5. HAPUS DATA (DELETE)
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if(!$mahasiswa){
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}
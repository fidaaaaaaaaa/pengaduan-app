<?php

namespace App\Http\Controllers;

use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\Aspirasi;

class InputAspirasiController extends Controller
{
    // Tampilkan form aspirasi siswa
    public function index()
    {
        $kategoris = Kategori::all();
        return view('aspirasi.form', compact('kategoris'));
    }

    // Simpan aspirasi dari siswa
        // Simpan aspirasi dari siswa
    public function store(Request $request)
    {
        $request->validate([
            'nis'         => 'required|integer|exists:siswa,nis',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'lokasi'      => 'required|string|max:50',
            'ket'         => 'required|string|max:50',
        ]);

        // 1. Simpan ke tabel input_aspirasi
        $input = InputAspirasi::create([
            'nis'         => $request->nis,
            'id_kategori' => $request->id_kategori,
            'lokasi'      => $request->lokasi,
            'ket'         => $request->ket,
            'tanggal'     => now()->toDateString(),
        ]);

        // 2. OTOMATIS buat record di tabel aspirasi (ini yang sebelumnya kurang)
        Aspirasi::create([
            'id_pelaporan' => $input->id_pelaporan,
            'status'       => 'Menunggu',
            'id_kategori'  => $request->id_kategori,
            'feedback'     => null,
        ]);

        return redirect()->route('aspirasi.form')
                         ->with('success', 'Aspirasi berhasil dikirim! Terima kasih.');
    }
}
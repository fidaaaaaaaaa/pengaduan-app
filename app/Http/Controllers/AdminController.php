<?php

namespace App\Http\Controllers;

use App\Models\InputAspirasi;
use App\Models\Admin;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Halaman Login Admin
    public function loginForm()
    {
        return view('admin.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && $request->password === $admin->password) {  // password plain (sesuai database)
            session(['admin_login' => true, 'admin_username' => $admin->username]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    // Logout
    public function logout()
    {
        session()->forget(['admin_login', 'admin_username']);
        return redirect()->route('admin.login');
    }

    // Dashboard Admin (List Aspirasi)
   public function dashboard(Request $request)
{
    if (!session('admin_login')) {
        return redirect()->route('admin.login');
    }

    $query = InputAspirasi::with(['siswa', 'kategori', 'aspirasi']);

    // Filter
    if ($request->filled('tanggal')) {
        $query->whereDate('tanggal', $request->tanggal);
    }
    if ($request->filled('nis')) {
        $query->where('nis', $request->nis);
    }
    if ($request->filled('kategori')) {
        $query->where('id_kategori', $request->kategori);
    }

    $aspirasis = $query->orderBy('tanggal', 'desc')->paginate(10);

    return view('admin.dashboard', compact('aspirasis'));
}

    // Simpan Umpan Balik & Status
    public function updateFeedback(Request $request, $id_pelaporan)
    {
        if (!session('admin_login')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'status'   => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'required|string',
        ]);

        Aspirasi::updateOrCreate(
            ['id_pelaporan' => $id_pelaporan],
            [
                'status'      => $request->status,
                'feedback'    => $request->feedback,
                'id_kategori' => $request->id_kategori ?? 1,
            ]
        );

        return back()->with('success', 'Umpan balik dan status berhasil disimpan!');
    }
}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Aspirasi Siswa</h4>
                    <p class="mb-0">Pengaduan Sarana dan Prasarana Sekolah</p>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('aspirasi.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">NIS Siswa</label>
                            <input type="number" name="nis" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Sarana</label>
                            <select name="id_kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="contoh: Lantai 2, Ruang 301" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan Pengaduan</label>
                            <textarea name="ket" class="form-control" rows="4" placeholder="Jelaskan masalahnya..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100">Kirim Aspirasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
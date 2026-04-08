@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard Admin - Daftar Aspirasi</h2>
        <a href="{{ route('admin.logout') }}" class="btn btn-secondary">Logout</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Feedback</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aspirasis as $item)
            @php $asp = $item->aspirasi; @endphp
            <tr>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->nis }}</td>
                <td>{{ $item->kategori->ket_kategori ?? '-' }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ $item->ket }}</td>
                <td>
                    <span class="badge bg-{{ $asp && $asp->status == 'Selesai' ? 'success' : ($asp && $asp->status == 'Proses' ? 'warning' : 'secondary') }}">
                        {{ $asp->status ?? 'Menunggu' }}
                    </span>
                </td>
                <td>{{ $asp->feedback ?? 'Belum ada umpan balik' }}</td>
                <td>
                    <button class="btn btn-sm btn-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#feedbackModal{{ $item->id_pelaporan }}">
                        Umpan Balik
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- MODAL UMPAN BALIK (diletakkan di luar tabel tapi masih di dalam loop) -->
    @foreach($aspirasis as $item)
    @php $asp = $item->aspirasi; @endphp
    <div class="modal fade" id="feedbackModal{{ $item->id_pelaporan }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.feedback', $item->id_pelaporan) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Umpan Balik Aspirasi #{{ $item->id_pelaporan }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <select name="status" class="form-select mb-3">
                            <option value="Menunggu" {{ ($asp && $asp->status == 'Menunggu') ? 'selected' : '' }}>Menunggu</option>
                            <option value="Proses"   {{ ($asp && $asp->status == 'Proses') ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai"  {{ ($asp && $asp->status == 'Selesai') ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <textarea name="feedback" class="form-control" rows="4" placeholder="Tulis umpan balik...">{{ $asp->feedback ?? '' }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection
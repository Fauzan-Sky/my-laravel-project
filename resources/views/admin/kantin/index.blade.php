@extends('layouts.admin')

@section('title', 'Kelola Kantin')

@section('content')
<div style="padding: 0.5rem 0;">

    {{-- Page Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
        <div>
            <h4 style="font-size:20px; font-weight:600; color:#0f4c5c; margin:0;">Kelola Kantin</h4>
            <p style="font-size:13px; color:#6b7280; margin:4px 0 0;">Total {{ $kantin->total() }} kantin terdaftar</p>
        </div>
        <a href="{{ route('admin.kantin.create') }}"
           style="font-size:13px; font-weight:600; padding:8px 16px; border-radius:8px; background:#0f4c5c; color:#fff; text-decoration:none;">
            + Tambah Kantin
        </a>
    </div>

    {{-- Tabel --}}
    <div style="background:#fff; border-radius:12px; border:0.5px solid #e2e8f0; overflow:hidden;">
        <table class="table table-hover mb-0">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">No</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Nama Kantin</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Lokasi</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Jam Buka</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Jam Tutup</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Status</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kantin as $i => $k)
                @php $isBuka = $k->status_operasional === 'buka'; @endphp
                <tr style="border-bottom:0.5px solid #f1f5f9;">
                    <td style="padding:12px 16px; font-size:14px; color:#6b7280;">{{ $kantin->firstItem() + $i }}</td>
                    <td style="padding:12px 16px; font-size:14px; font-weight:500; color:#0f4c5c;">{{ $k->nama_kantinn }}</td>
                    <td style="padding:12px 16px; font-size:14px; color:#6b7280;">{{ $k->lokasi }}</td>
                    <td style="padding:12px 16px; font-size:14px; color:#374151;">{{ $k->jam_buka ?? '-' }}</td>
                    <td style="padding:12px 16px; font-size:14px; color:#374151;">{{ $k->jam_tutup ?? '-' }}</td>

                    {{-- Toggle Status --}}
                    <td style="padding:12px 16px;">
                        <form action="{{ route('admin.kantin.toggleStatus', $k->id) }}" method="POST" style="margin:0;">
                            @csrf @method('PATCH')
                            <button type="submit"
                                data-msg="Ubah status {{ $k->nama_kantinn }} menjadi {{ $isBuka ? 'Tutup' : 'Buka' }}?"
                                onclick="return confirm(this.dataset.msg)"
                                style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:20px; border:none; cursor:pointer;
                                    {{ $isBuka ? 'background:#dcfce7; color:#166534;' : 'background:#fee2e2; color:#991b1b;' }}">
                                {{ $isBuka ? 'Buka' : 'Tutup' }}
                            </button>
                        </form>
                    </td>

                    {{-- Aksi --}}
                    <td style="padding:12px 16px;">
                        <div style="display:flex; gap:8px; align-items:center;">
                            <a href="{{ route('admin.kantin.edit', $k->id) }}"
                               style="font-size:12px; font-weight:600; padding:4px 12px; border-radius:6px; background:#e1f5ee; color:#0f6e56; text-decoration:none;">
                                Edit
                            </a>
                            <form action="{{ route('admin.kantin.destroy', $k->id) }}" method="POST"
                                  data-nama="{{ $k->nama_kantinn }}"
                                  onsubmit="return confirm('Yakin hapus kantin ' + this.dataset.nama + '?')"
                                  style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    style="font-size:12px; font-weight:600; padding:4px 12px; border-radius:6px; background:#fee2e2; color:#991b1b; border:none; cursor:pointer;">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:2.5rem; color:#9ca3af; font-size:14px;">
                        Belum ada data kantin.
                        <a href="{{ route('admin.kantin.create') }}" style="color:#0f4c5c; font-weight:600;">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="margin-top:1rem;">
        {{ $kantin->links() }}
    </div>

</div>
@endsection
@extends('layouts.admin')

@section('title', 'Kelola Siswa')

@section('content')
<div style="padding: 0.5rem 0;">

    {{-- Page Header --}}
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-size: 20px; font-weight: 600; color: #0f4c5c; margin: 0;">Kelola Siswa</h4>
        <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0;">Total {{ $siswa->total() }} siswa terdaftar</p>
    </div>

    {{-- Tabel --}}
    <div style="background:#fff; border-radius:12px; border:0.5px solid #e2e8f0; overflow:hidden;">
        <table class="table table-hover mb-0">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">No</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">NIS</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Nama Lengkap</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Kelas</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">No. HP</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Total Pesanan</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Total Pengeluaran</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Status</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $i => $s)
                <tr style="border-bottom:0.5px solid #f1f5f9;">
                    <td style="padding:12px 16px; font-size:14px; color:#6b7280;">{{ $siswa->firstItem() + $i }}</td>
                    <td style="padding:12px 16px; font-size:13px; font-family:monospace; color:#374151;">{{ $s->nis }}</td>
                    <td style="padding:12px 16px; font-size:14px; font-weight:500; color:#0f4c5c;">{{ $s->nama_lengkap }}</td>
                    <td style="padding:12px 16px; font-size:14px; color:#374151;">{{ $s->kelas }}</td>
                    <td style="padding:12px 16px; font-size:14px; color:#374151;">{{ $s->nomer_hp ?? '-' }}</td>
                    <td style="padding:12px 16px; font-size:14px; color:#374151;">{{ $s->pesanan_count }} pesanan</td>
                    <td style="padding:12px 16px; font-size:14px; font-weight:500; color:#374151;">Rp {{ number_format($s->pesanan_sum_total_harga ?? 0, 0, ',', '.') }}</td>

                    {{-- Status --}}
                    <td style="padding:12px 16px;">
                        <span style="display:inline-block; font-size:11px; font-weight:600; padding:3px 10px; border-radius:20px;
                            {{ $s->is_active ? 'background:#dcfce7; color:#166534;' : 'background:#fee2e2; color:#991b1b;' }}">
                            {{ $s->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td style="padding:12px 16px;">
                        <div style="display:flex; gap:8px; align-items:center;">
                            <a href="{{ route('admin.siswa.edit', $s->id) }}"
                               style="font-size:12px; font-weight:600; padding:4px 12px; border-radius:6px; background:#e1f5ee; color:#0f6e56; text-decoration:none;">
                                Edit
                            </a>
                            <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus siswa {{ $s->nama_lengkap }}?')" style="margin:0;">
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
                    <td colspan="9" style="text-align:center; padding:2.5rem; color:#9ca3af; font-size:14px;">
                        Belum ada data siswa
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="margin-top:1rem;">
        {{ $siswa->links() }}
    </div>

</div>
@endsection
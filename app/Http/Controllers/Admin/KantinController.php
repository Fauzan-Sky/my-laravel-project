<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kantin;
use Illuminate\Http\Request;

class KantinController extends Controller
{
    public function index()
    {
        $kantin = Kantin::paginate(10);
        return view('admin.kantin.index', compact('kantin'));
    }

    public function create()
    {
        return view('admin.kantin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kantinn'       => 'required|string|max:255',
            'lokasi'             => 'required|string',
            'deskripsi'          => 'nullable|string',
            'jam_buka'           => 'nullable',
            'jam_tutup'          => 'nullable',
            'status_operasional' => 'required|in:buka,tutup',
        ]);

        Kantin::create($request->only([
            'nama_kantinn', 'lokasi', 'deskripsi',
            'jam_buka', 'jam_tutup', 'status_operasional',
        ]));

        return redirect()->route('admin.kantin.index')
            ->with('success', 'Kantin berhasil ditambahkan!');
    }

    public function show(Kantin $kantin)
    {
        return redirect()->route('admin.kantin.edit', $kantin);
    }

    public function edit(Kantin $kantin)
    {
        return view('admin.kantin.edit', compact('kantin'));
    }

    public function update(Request $request, Kantin $kantin)
    {
        $request->validate([
            'nama_kantinn'       => 'required|string|max:255',
            'lokasi'             => 'required|string',
            'deskripsi'          => 'nullable|string',
            'jam_buka'           => 'nullable',
            'jam_tutup'          => 'nullable',
            'status_operasional' => 'required|in:buka,tutup',
        ]);

        $kantin->update($request->only([
            'nama_kantinn', 'lokasi', 'deskripsi',
            'jam_buka', 'jam_tutup', 'status_operasional',
        ]));

        return redirect()->route('admin.kantin.index')
            ->with('success', 'Kantin berhasil diperbarui!');
    }

    public function destroy(Kantin $kantin)
    {
        $kantin->delete();

        return redirect()->route('admin.kantin.index')
            ->with('success', 'Kantin berhasil dihapus!');
    }

    public function toggleStatus(Kantin $kantin)
    {
        $statusBaru = $kantin->status_operasional === 'buka' ? 'tutup' : 'buka';

        $kantin->update(['status_operasional' => $statusBaru]);

        return redirect()->back()
            ->with('success', 'Status kantin "' . $kantin->nama_kantinn . '" diubah menjadi ' . strtoupper($statusBaru) . '!');
    }
}
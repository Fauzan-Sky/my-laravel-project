<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SlotWaktu;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index()
    {
        $slotList = SlotWaktu::orderBy('jam_mulai')->get();
        return view('admin.slot', compact('slotList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label_slot'  => ['required', 'string', 'max:100'],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ]);

        SlotWaktu::create([
            'label_slot'  => $request->label_slot,
            'jam_mulai'   => $request->jam_mulai . ':00',
            'jam_selesai' => $request->jam_selesai . ':00',
            'is_active'   => true,
        ]);

        return back()->with('success', 'Slot jadwal berhasil ditambahkan.');
    }

    public function toggle($id)
    {
        $slot = SlotWaktu::findOrFail($id);
        $slot->update(['is_active' => !$slot->is_active]);
        return back()->with('success', 'Status slot berhasil diubah.');
    }

    public function destroy($id)
    {
        SlotWaktu::findOrFail($id)->delete();
        return back()->with('success', 'Slot jadwal berhasil dihapus.');
    }
}
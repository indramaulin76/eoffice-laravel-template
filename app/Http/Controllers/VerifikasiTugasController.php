<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\LuaranTugas;
use App\Models\VerifikasiLuaranTugas;
use Illuminate\Http\Request;

class VerifikasiTugasController extends Controller
{
    public function index()
    {
        $title = 'Verifikasi Tugas';
        $luaranTugas = auth()->user()->luaranTugasBawahan()->with('pegawai:id,nama')->get();

        return view('verifikasi-tugas.index', compact('title','luaranTugas'));
    }

    public function show(LuaranTugas $tugas)
    {
        $title = 'Verifikasi Tugas';

        return view('verifikasi-tugas.show', compact('title','tugas'));
    }

    public function terima(LuaranTugas $tugas)
    {
        $tugas->update([
            'status' => 'disetujui',
        ]);

        VerifikasiLuaranTugas::create([
            'luaran_tugas_id' => $tugas->id,
            'verifikatur_id' => auth()->id(),
            'status' => 'disetujui',
        ]);

        Log::create([
            'pegawai_id' => $tugas->pegawai_id,
            'kegiatan_id' => $tugas->id,
            'bobot' => $tugas->bobot,
        ]);

        return redirect()->route('tugas.verifikasi.show', ['tugas' => $tugas->id])->with('success', 'Tugas berhasil diverifikasi');
    }

    public function tolak(Request $request, LuaranTugas $tugas)
    {
        $tugas->update([
            'status' => 'ditolak',
        ]);

        VerifikasiLuaranTugas::create([
            'luaran_tugas_id' => $tugas->id,
            'verifikatur_id' => auth()->id(),
            'status' => 'ditolak',
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('tugas.verifikasi.show', ['tugas' => $tugas->id]);
    }
}

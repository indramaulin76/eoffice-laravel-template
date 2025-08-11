<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\VerifikasiSuratKeluar;
use Illuminate\Http\Request;

class VerifikasiSuratKeluarController extends Controller
{
    public function index() {
        $title = 'Verifikasi Surat Keluar';
        $suratKeluar = SuratKeluar::all();

        return view('surat-keluar.verifikasi.index',compact('title','suratKeluar'));
    }

    public function show(SuratKeluar $surat) {

        return view('surat-keluar.verifikasi.show',compact('surat'));
    }

    public function terima(SuratKeluar $surat)
    {
        // dd('sampe sini');
        $surat->update([
            'status' => 'Disetujui',
        ]);

        VerifikasiSuratKeluar::create([
            'surat_keluar_id' => $surat->id,
            'verifikatur_id' => auth()->id(),
            'status' => 'Disetujui',
        ]);

        // TODO : Hitung bobot dan bikin log

        // $bobot = $this->hitungBobotPerjalananDinas($laporan->perjalananDinas->waktu_mulai, $laporan->perjalananDinas->waktu_selesai);
        // Log::create([
        //     'pegawai_id' => auth()->id(),
        //     'kegiatan_id' => $laporan->perjalananDinas->id,
        //     'bobot' => $bobot,
        // ]);

        return redirect()->route('surat-keluar.verifikasi.show',['surat' => $surat])->with('success', 'Surat keluar berhasil diverifikasi');

    }

    public function tolak(Request $request, SuratKeluar $surat)
    {
        // dd('sampe sini');
        $request->validate([
            'catatan' => 'required',
        ]);

        $surat->update([
            'status' => 'Ditolak',
        ]);

        VerifikasiSuratKeluar::create([
            'surat_keluar_id' => $surat->id,
            'verifikatur_id' => auth()->id(),
            'status' => 'Ditolak',
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('surat-keluar.verifikasi.show',['surat' => $surat])->with('success', 'Laporan perjalanan dinas berhasil diverifikasi');
    }
}

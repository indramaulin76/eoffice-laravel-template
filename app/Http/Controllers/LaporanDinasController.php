<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaporanDinasRequest;
use App\Models\LaporanPerjalananDinas;
use App\Models\PerjalananDinas;
use Illuminate\Http\Request;

class LaporanDinasController extends Controller
{
    public function index()
    {
        $title = 'Laporan Dinas';
        $perjalananDinas = PerjalananDinas::where('pemberi_perintah_id', auth()->user()->id)->with('laporanPerjalananDinas','pemberiPerintah:id,nama','pelaksana:id,nama')->whereHas('laporanPerjalananDinas')->get();
        return view('laporan-dinas.index', compact('title','perjalananDinas'));
    }

    public function create()
    {
        $title = 'Buat Laporan Dinas';
        return view('laporan-dinas.create', compact('title'));
    }

    public function store(LaporanDinasRequest $request)
    {
        try {
            $file = $request->file('file_laporan');

            // Generate nama file dengan timestamp
            $namaFile = time() . '_' . $file->getClientOriginalName();

            // Simpan file dengan nama yang baru
            $file->storeAs('/public/laporan-dinas', $namaFile);

            // Simpan data laporan perjalanan dinas
            LaporanPerjalananDinas::create([
                'pegawai_id' => auth()->id(),
                'perjalanan_dinas_id' => $request->perjalanan_dinas_id,
                'file_laporan' => 'laporan-dinas/' . $namaFile,
                'keterangan' => $request->keterangan,
                'waktu_pengumpulan' => now(),
                'status' => 'Dalam Proses',
            ]);

            return redirect()->route('sppd.show',['sppd' => $request->perjalanan_dinas_id])->with('success', 'Laporan berhasil di-upload');
        } catch (\Exception $e) {
            // Tangani exception dan beri feedback ke user
            return back()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(PerjalananDinas $perjalananDinas)
    {
        $title = 'Detail Laporan Dinas';
        $perjalananDinas->load('laporanPerjalananDinas');
        

        return view('laporan-dinas.show', compact('title', 'perjalananDinas'));
    }

    public function edit(LaporanPerjalananDinas $laporan)
    {
        $title = 'Edit Laporan Dinas';
        return view('laporan-dinas.edit', compact('title', 'laporan'));
    }

    public function update(LaporanDinasRequest $request, LaporanPerjalananDinas $laporan)
    {
        try {
            if ($request->hasFile('file_laporan')) {
                // Dapatkan file baru
                $file = $request->file('file_laporan');

                // Generate nama file dengan timestamp
                $namaFile = time() . '_' . $file->getClientOriginalName();

                // Hapus file lama dari storage
                if ($laporan->file_laporan) {
                    $filePath = storage_path('app/laporan-dinas/' . $laporan->file_laporan);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                // Simpan file baru
                $file->storeAs('laporan-dinas', $namaFile);

                // Update file_laporan di database
                $laporan->file_laporan = $namaFile;
            }

            // Update data laporan perjalanan dinas
            $laporan->update([
                'keterangan' => $request->keterangan,
                'waktu_pengumpulan' => $request->waktu_pengumpulan,
                'status' => 'Dalam Proses',
            ]);

            return redirect()->route('laporan-dinas.index')->with('success', 'Laporan berhasil di-update');
        } catch (\Exception $e) {
            // Tangani exception dan beri feedback ke user
            return back()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(LaporanPerjalananDinas $laporan)
    {
        try {
            // Hapus file dari storage
            if ($laporan->file_laporan) {
                $filePath = storage_path('app/laporan-dinas/' . $laporan->file_laporan);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus data laporan perjalanan dinas
            $laporan->delete();

            return redirect()->route('laporan-dinas.index')->with('success', 'Laporan berhasil dihapus');
        } catch (\Exception $e) {
            // Tangani exception dan beri feedback ke user
            return back()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}

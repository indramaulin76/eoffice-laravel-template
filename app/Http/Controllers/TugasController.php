<?php

namespace App\Http\Controllers;

use App\Http\Requests\LuaranTugasRequest;
use App\Models\LuaranTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TugasController extends Controller
{
    public function index()
    {
        $title = 'Tugas';
        $daftarTugas = LuaranTugas::where('pegawai_id', auth()->id())->latest()->get();
        return view('tugas.index', compact('title', 'daftarTugas'));
    }

    public function create()
    {
        $title = 'Tambah Tugas';
        $user = auth()->user();

        $response = Http::get('http://anjab-abk.test/api/uraian-tugas-by-jabatan-and-supervisor', 
        [
            'jabatan_id' => auth()->user()->jabatan_id,
            'supervisor_id' => $user->supervisor->userTutam->tutam_id,
        ]);

        $detailAbk = $response->json()['data'];

        return view('tugas.create', compact('title', 'detailAbk'));
    }

    public function store(LuaranTugasRequest $request)
    {
        $file = $request->file('file');
        $namaFile = time() . '_' . $file->getClientOriginalName();

        if (!$file->storeAs('luaran_tugas', $namaFile, 'public')) {
            return back()->withErrors(['msg' => 'File gagal diupload']);
        }

        // Simpan data tugas
        $luaran = LuaranTugas::create([
            'pegawai_id' => auth()->id(),
            'uraian_tugas' => $request->uraian,
            'bobot' => $request->bobot,
            'target' => $request->target,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'file_luaran' => $namaFile,
            'waktu_pengumpulan' => now(),
            'status' => 'sedang diperiksa',
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function show(LuaranTugas $tugas)
    {
        $title = 'Detail Tugas';
        return view('tugas.show', compact('title', 'tugas'));
    }

    public function edit(LuaranTugas $tugas)
    {
        $title = 'Edit Tugas';
        return view('tugas.edit', compact('title', 'tugas'));
    }

    public function update(LuaranTugasRequest $request, LuaranTugas $tugas)
    {
        // Cek apakah user upload file baru
        if ($request->hasFile('file')) {
            // Dapatkan file baru
            $file = $request->file('file');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            // Hapus file lama dari storage
            if ($tugas->file) {
                $filePath = storage_path('app/luaran_tugas/' . $tugas->file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Simpan file baru
            $file->storeAs('luaran_tugas', $namaFile, 'public');

            // Update file di database
            $tugas->file = $namaFile;
        }

        // Update data lainnya
        $tugas->update([
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'waktu_pengumpulan' => now(),
            'status' => 'sedang diperiksa',
            // file udah diupdate di atas kalau ada file baru
        ]);

        return redirect()->route('tugas.show', ['tugas' => $tugas->id]);
    }

    public function destroy(LuaranTugas $tugas)
    {
        try {
            // Hapus file dari storage
            if ($tugas->file) {
                $filePath = storage_path('app/luaran_tugas/' . $tugas->file);
                if (file_exists($filePath)) {
                    if (!unlink($filePath)) {
                        return back()->withErrors(['msg' => 'Gagal menghapus file']);
                    }
                }
            }

            // Hapus data tugas
            $tugas->delete();

            return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}

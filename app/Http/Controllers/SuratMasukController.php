<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuratMasukRequest;
use App\Models\Log;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index()
    {
        $title = 'Surat Masuk';
        $suratMasuk = SuratMasuk::all();
        return view('surat-masuk.index', compact('title', 'suratMasuk'));
    }

    public function create()
    {
        $title = 'Tambah Surat Masuk';
        return view('surat-masuk.create', compact('title'));
    }

    public function store(SuratMasukRequest $request)
    {
        $surat = $request->file('file_surat');
        $namaSurat = time() . '_' . $surat->getClientOriginalName();
        $surat->storeAs('/surat_masuk', $namaSurat, 'public');

        // Simpan data surat
        $surat = SuratMasuk::create([
            'pengarsip_id' => auth()->id(),
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'asal' => $request->asal,
            'tujuan' => $request->tujuan,
            'file_surat' => $namaSurat,
            'tanggal_diterima' => $request->tanggal_surat,
        ]);

        Log::create([
            'pegawai_id' => auth()->id(),
            'kegiatan_id' => $surat->id,
            'bobot' => 30,
        ]);

        return redirect()->route('surat-masuk.index');
    }

    public function show(SuratMasuk $surat)
    {
        $title = 'Detail Surat Masuk';
        return view('surat-masuk.show', compact('title', 'surat'));
    }

    public function edit(SuratMasuk $surat)
    {
        $title = 'Edit Surat Masuk';
        return view('surat-masuk.edit', compact('title', 'surat'));
    }

    public function update(SuratMasukRequest $request, SuratMasuk $surat)
    {
        // Cek kalo ada file baru di request
        if ($request->hasFile('file_surat')) {
            // Hapus file lama
            $fileLama = storage_path('app/surat_masuk/' . $surat->file_surat);
            if (file_exists($fileLama)) {
                unlink($fileLama); // hapus file lama
            }

            // Simpan file baru
            $suratBaru = $request->file('file_surat');
            $namaSuratBaru = time() . '_' . $suratBaru->getClientOriginalName();
            $suratBaru->storeAs('surat_masuk', $namaSuratBaru, 'public');

            // Update file_surat di database
            $surat->file_surat = $namaSuratBaru;
        }

        // Update data surat lainnya
        $surat->update([
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'asal' => $request->asal,
            'tujuan' => $request->tujuan,
            'tanggal_surat' => $request->tanggal_surat,
        ]);

        return redirect()->route('surat-masuk.index');
    }

    public function destroy(SuratMasuk $surat)
    {
        $fileLama = storage_path('app/surat_masuk/' . $surat->file_surat);
        if (file_exists($fileLama)) {
            unlink($fileLama); // hapus file lama
        }

        $surat->delete();
        return redirect()->route('surat-masuk.index');
    }
}

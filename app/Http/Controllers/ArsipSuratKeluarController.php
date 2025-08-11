<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArsipSuratKeluarRequest;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipSuratKeluarController extends Controller
{
    public function index() {
        $title = 'Arsip Surat Keluar';
        $suratKeluar = SuratKeluar::where('status','Disetujui')->get();

        return view('surat-keluar.arsip.index',compact('title','suratKeluar'));
    }

    public function show(SuratKeluar $surat) {
        $title = 'Detail Surat Keluar';

        return view('surat-keluar.arsip.show',compact('title','surat'));
    }

    public function update(ArsipSuratKeluarRequest $request, SuratKeluar $surat) {

        // delete the current file arsip, if available
        if($surat->file_arsip) {
            Storage::disk('public')->delete('arsip-surat-keluar/'.$surat->file_arsip);
        }

        // save the surat data into the arsip-surat-keluar directory
        $fileArsip = $request->file('file_arsip');
        $fileName = 'ARSIP-'. $surat->nomor_surat . '.' . $fileArsip->extension();
        $fileArsip->storeAs('arsip-surat-keluar',$fileName,'public');

        // update the surat data
        $surat->update([
            'file_arsip' => $fileName
        ]);

        return redirect()->route('surat-keluar.arsip.show',['surat' => $surat])->with('success',' Arsip Surat Keluar berhasil dibuat/diperbarui');

        // TODO : Create Log for this activity


    }
}

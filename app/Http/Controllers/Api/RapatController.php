<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PresensiRapat;
use App\Models\Rapat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RapatController extends Controller
{
    public function getDurationTargetById($id)
    {
        $presensis = PresensiRapat::where('pegawai_id', $id)->get();

        $rapats = $presensis->map(function ($presensi) {
            return $presensi->rapat;
        });

        $durasiRapatUser = Rapat::hitungTotalDurasi($rapats);

        return response()->json([
            'message' => 'Berhasil menampilkan data',
            'data' => $durasiRapatUser
        ]);
    }
}

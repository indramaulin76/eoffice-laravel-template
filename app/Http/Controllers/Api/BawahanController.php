<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\LuaranTugas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BawahanController extends Controller
{
  public function getById($id)
  {
    $bawahans = User::where('supervisor_id', $id)->get();

    foreach ($bawahans as $bawahan) {
      $total_target = Http::get('http://anjab-abk.test/api/yearly-total-uraian-tugas-target-by-jabatan-and-supervisor', [
        'jabatan_id' => $bawahan->jabatan_id,
        'supervisor_id' => $bawahan->supervisor->userTutam->tutam_id,
      ])->json()['total_target'] / 12;

      $total_realisasi = LuaranTugas::where('pegawai_id', $bawahan->id)
        ->where('status', 'disetujui')
        ->whereMonth('created_at', Carbon::now()->month)
        ->sum('bobot');

      $rapat = Log::where('pegawai_id', $bawahan->id)
        ->where('kegiatan_id', 'like', 'R%')
        ->whereMonth('created_at', Carbon::now()->month)
        ->sum('bobot');

      $perjalananDinas = Log::where('pegawai_id', $bawahan->id)
        ->where('kegiatan_id', 'like', 'D%')
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();

      $bawahan['kinerja'] = number_format($total_realisasi / $total_target * 100, 1, '.', '');
      $bawahan['rapat'] = $rapat;
      $bawahan['perjalanan_dinas'] = $perjalananDinas;
    }

    return response()->json([
      'message' => 'Berhasil menampilkan data',
      'data' => $bawahans
    ]);
  }
}

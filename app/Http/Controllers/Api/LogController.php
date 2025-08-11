<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogResource;
use App\Models\HariLibur;
use App\Models\Log;
use App\Models\LuaranTugas;
use App\Models\PerjalananDinas;
use App\Models\PresensiRapat;
use App\Models\Rapat;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function getById($id, Request $request)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan',
                'data' => null
            ], 404);
        }

        // presensi start
        $totalBobotPresensi = Log::where('pegawai_id', $id)
            ->where('kegiatan_id', 'like', 'P%')
            ->when($request->startDate, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->startDate);
            })
            ->when($request->endDate, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->endDate);
            })
            ->sum('bobot');

        $startOfYear = Carbon::now()->startOfYear();
        $today = Carbon::now();

        $period = CarbonPeriod::create($startOfYear, $today);

        $totalWorkDays = 0;
        foreach ($period as $date) {
            if (!$date->isWeekend()) {
                $totalWorkDays++;
            }
        }

        $jumlahHariLibur = HariLibur::whereBetween('tanggal', [$startOfYear, $today])->count();

        $targetPresensi = ($totalWorkDays - $jumlahHariLibur) * 60;
        // presensi end

        // rapat start
        $totalBobotRapat = Log::where('pegawai_id', $id)
            ->where('kegiatan_id', 'like', 'R%')
            ->when($request->startDate, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->startDate);
            })
            ->when($request->endDate, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->endDate);
            })
            ->when($request->bulan && $request->tahun, function($query) use ($request) {
                $query->whereMonth('created_at', $request->bulan)
                ->whereYear('created_at', $request->tahun);
            })
            ->sum('bobot');

        // $presensis = PresensiRapat::where('pegawai_id', $id)->get();
        // $rapats = $presensis->map(function ($presensi) {
        //     return $presensi->rapat;
        // });
        // $targetRapat = Rapat::hitungTotalDurasi($rapats);
        // rapat end

        // perjalanan dinas start
        $totalBobotPerjalananDinas = Log::where('pegawai_id', $id)
            ->where('kegiatan_id', 'like', 'D%')
            ->when($request->startDate, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->startDate);
            })
            ->when($request->endDate, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->endDate);
            })
            ->when($request->bulan && $request->tahun, function($query) use ($request) {
                $query->whereMonth('created_at', $request->bulan)
                ->whereYear('created_at', $request->tahun);
            })
            ->sum('bobot');

        $perjalananDinas = PerjalananDinas::where('pelaksana_id', $id)->get();
        $targetPerjalananDinas = 0;
        // perjalanan dinas end

        $dataUraianTugas = LuaranTugas::where('pegawai_id', $id)
            ->where('status', 'disetujui')
            ->when($request->startDate, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->startDate);
            })
            ->when($request->endDate, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->endDate);
            })
            ->when($request->bulan && $request->tahun, function($query) use ($request) {
                $query->whereMonth('created_at', $request->bulan)
                ->whereYear('created_at', $request->tahun);
            })
            ->select('uraian_tugas', 'target')
            ->selectRaw('SUM(bobot) as total_bobot')
            ->groupBy('uraian_tugas', 'target')
            ->get();

        $arrayUraianTugas = [];
        foreach ($dataUraianTugas as $uraianTugas) {
            $arrayUraianTugas[] = [
                'nama' => $uraianTugas->uraian_tugas,
                'target' => $uraianTugas->target,
                'total' => $uraianTugas->total_bobot
            ];
        }

        $mergedLog = array_merge($arrayUraianTugas, [
            [
                'nama' => 'Presensi',
                'target' => $targetPresensi,
                'total' => $totalBobotPresensi
            ],
            [
                'nama' => 'Rapat',
                'target' => null,
                'total' => $totalBobotRapat
            ],
            [
                'nama' => 'Perjalanan Dinas',
                'target' => $targetPerjalananDinas,
                'total' => $totalBobotPerjalananDinas
            ]
        ]);

        return response()->json([
            'message' => 'Berhasil menampilkan data',
            'data' => $mergedLog
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        $pegawais = User::all();
        $events = array();
        $rapats = Rapat::all();

        foreach ($rapats as $rapat) {
            $events[] = [
                'id' => $rapat->id,
                'title' => $rapat->judul,
                'perihal' => $rapat->perihal,
                'tempat' => $rapat->tempat,
                'pemimpinRapat' => $rapat->pemimpin_rapat_id,
                'start' => $rapat->waktu_mulai,
                'end' => $rapat->waktu_selesai,
                'color' => $rapat->warna_label ? $rapat->warna_label : '',
                
                'startTime' => Carbon::parse($rapat->waktu_mulai)->format('H:i:s'),
                'endTime' => Carbon::parse($rapat->waktu_selesai)->format('H:i:s'),
                
                'hariTanggal' => $rapat->hariTanggal(),
                'waktuMulai' => $rapat->waktuMulai(),
                'waktuSelesai' => $rapat->waktuSelesai(),
                'pesertaRapat' => $rapat->pesertaRapat(),
            ];
        }

        return view('dashboard.modern', compact('title', 'events', 'pegawais', 'rapats'));
    }
}

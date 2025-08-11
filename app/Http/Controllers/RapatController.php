<?php

namespace App\Http\Controllers;


use App\Http\Requests\RapatRequest;
use App\Models\Log;
use App\Models\Pegawai;
use App\Models\PresensiRapat;
use App\Models\Rapat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RapatController extends Controller
{
    public function index()
    {
        // rapats is a collection of Rapat instances where user has presensi rapat of it
        $rapats = Rapat::whereHas('presensiRapat', function ($query) {
            $query->where('pegawai_id', auth()->user()->id);
        })->latest()->get();

        $pastRapats = $rapats->filter(function ($rapat) {
            return Carbon::parse($rapat->waktu_selesai)->isPast();
        });
        
        $onGoingRapats = $rapats->filter(function ($rapat) {
            return Carbon::parse($rapat->waktu_mulai)->isPast() && Carbon::parse($rapat->waktu_selesai)->isFuture();
        });

        $upcomingRapats = $rapats->filter(function ($rapat) {
            return Carbon::parse($rapat->waktu_mulai)->isFuture();
        });

        return view('rapat.index', compact( 'onGoingRapats' ,'pastRapats', 'upcomingRapats'));
    }

    public function create()
    {
        $title = 'Buat Rapat';
        $pegawais = User::all();
        return view('rapat.create', compact('title', 'pegawais'));
    }

    public function show(Rapat $rapat)
    {
        $title = 'Detail Rapat';
        $pesertas = PresensiRapat::where('rapat_id', $rapat->id)->get();
        $pegawais = User::all();
        return view('rapat.detail', compact('title', 'rapat', 'pesertas', 'pegawais'));
    }

    public function store(RapatRequest $request)
    {
        $waktuMulai = Carbon::parse($request->tanggal . ' ' . $request->waktuMulai);
        $waktuSelesai = Carbon::parse($request->tanggal . ' ' . $request->waktuSelesai);
        // dd($waktuMulai, $waktuSelesai);

        $rapatData = [
            'judul' => $request->judul,
            'perihal' => $request->perihal,
            'tempat' => $request->tempat,
            'pemimpin_rapat_id' => $request->pemimpinRapat,
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
        ];

        // if request has 'warnaLabel', then add 'warna_label' to $rapatData, otherwise use default color
        if ($request->warnaLabel) {
            $rapatData['warna_label'] = $request->warnaLabel;
        }

        $createdRapat = Rapat::create($rapatData);

        foreach ($request->pesertaRapat as $peserta) {
            // dd($peserta);
            PresensiRapat::create([
                'rapat_id' => $createdRapat->id,
                'pegawai_id' => $peserta,
                'status' => $peserta == $createdRapat->pemimpin_rapat_id ? 'hadir' : 'notset',
            ]);
        }

        // if there is no PresensiRapat instance where rapat id is $rapat->id and peserta id is $request->pemimpinRapat, then create new PresensiRapat instance
        if (!PresensiRapat::where('rapat_id', $createdRapat->id)->where('pegawai_id', $createdRapat->pemimpin_rapat_id)->first()) {
            PresensiRapat::create([
                'rapat_id' => $createdRapat->id,
                'pegawai_id' => $request->pemimpinRapat,
                'status' => 'hadir',
            ]);
        }

        return redirect()->route('rapat.index')->with('success', 'Rapat berhasil dibuat.');
    }

    public function update(RapatRequest $request, Rapat $rapat)
    {
        // if rapat not found, return 404
        if (!$rapat) {
            return response()->json(['error' => 'rapat not found'], 404);
        }

        // if request doesn't have color, it means the process is drag and drop
        if (!$request->warnaLabel) {
            $rapat->update([
                'waktu_mulai' => $request->waktuMulai,
                'waktu_selesai' => $request->waktuSelesai,
            ]);

            return response()->json($rapat);
        }

        // updated rapat data from request
        $updatedRapatData = [
            'judul' => $request->judul,
            'perihal' => $request->perihal,
            'tempat' => $request->tempat,
            'pemimpin_rapat_id' => $request->pemimpinRapat,
            'waktu_mulai' => $request->waktuMulai,
            'waktu_selesai' => $request->waktuSelesai,
            'warna_label' => $request->warnaLabel,
        ];

        // if request has tanggal, then adjust waktuMulai and waktuSelesai
        if ($request->has('tanggal')) {
            $waktuMulai = $request->tanggal . ' ' . $request->waktuMulai;
            $waktuSelesai = $request->tanggal . ' ' . $request->waktuSelesai;

            $updatedRapatData['waktu_mulai'] = $waktuMulai;
            $updatedRapatData['waktu_selesai'] = $waktuSelesai;
        }

        // update rapat data in database
        $rapat->update($updatedRapatData);

        // Ambil peserta presensi yang sudah ada
        $currentPeserta = PresensiRapat::where('rapat_id', $rapat->id)->pluck('pegawai_id')->toArray();

        // Ambil peserta baru dari request
        $newPeserta = $request->pesertaRapat;

        // Peserta yang harus ditambahkan
        $pesertaToAdd = array_diff($newPeserta, $currentPeserta);

        // Peserta yang harus dihapus
        $pesertaToRemove = array_diff(
            $currentPeserta,
            $newPeserta
        );

        // Tambahkan peserta baru ke presensi
        foreach ($pesertaToAdd as $peserta) {
            PresensiRapat::create([
                'rapat_id' => $rapat->id,
                'pegawai_id' => $peserta,
                'status' => 'hadir',
            ]);
        }

        // Hapus peserta yang sudah tidak ada di request
        PresensiRapat::where('rapat_id', $rapat->id)
            ->whereIn('pegawai_id', $pesertaToRemove)
            ->delete();

        // Cek apakah pemimpin rapat sudah ada di presensi, kalau belum tambahkan
        if (!PresensiRapat::where('rapat_id', $rapat->id)->where('pegawai_id', $rapat->pemimpin_rapat_id)->exists()) {
            PresensiRapat::create([
                'rapat_id' => $rapat->id,
                'pegawai_id' => $rapat->pemimpin_rapat_id,
                'status' => 'hadir',
            ]);
        }

        if ($request->has('tanggal')) {
            return redirect()->route('rapat.index')->with('success', 'Rapat ' . $rapat->judul . ' berhasil diupdate.');
        }

        return response()->json([
            'id' => $rapat->id,
            'title' => $rapat->judul,
            'start' => $rapat->waktu_mulai,
            'end' => $rapat->waktu_selesai,
            'color' => $rapat->warna_label ? $rapat->warna_label : '',
            'startTime' => Carbon::parse($rapat->waktu_mulai)->format('H:i:s'),
            'endTime' => Carbon::parse($rapat->waktu_selesai)->format('H:i:s'),
        ]);
    }

    public function destroy(Rapat $rapat)
    {
        $rapat->delete();

        return response()->json($rapat);
    }

    public function updatePresensiPeserta(Request $request, Rapat $rapat, User $peserta)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,notset',
        ]);

        // Ambil status presensi yang sekarang sebelum update
        $presensi = PresensiRapat::where('rapat_id', $rapat->id)
            ->where('pegawai_id', $peserta->id)
            ->first();

        // Jika status bukan 'notset' (berarti hadir atau izin)
        if ($request->status !== 'notset') {
            // Cek apakah sebelumnya status 'notset', jika iya maka buat Log baru
            if ($presensi->status === 'notset') {
                $bobot = $this->hitungDurasiRapat($rapat->waktu_mulai, $rapat->waktu_selesai);

                // Buat log baru untuk rapat ini
                Log::create([
                    'pegawai_id' => $peserta->id,
                    'kegiatan_id' => $rapat->id,
                    'bobot' => $bobot,
                ]);
            }
        } else {
            // Jika status berubah jadi 'notset', hapus Log yang sebelumnya dibuat
            Log::where('pegawai_id', $peserta->id)
                ->where('kegiatan_id', $rapat->id)
                ->delete();
        }

        // Update presensi dengan status baru
        $presensi->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Presensi peserta rapat berhasil diupdate.',
        ]);
    }

    protected function hitungDurasiRapat($waktuMulai, $waktuSelesai)
    {
        $waktuMulai = strtotime($waktuMulai);
        $waktuSelesai = strtotime($waktuSelesai);

        $diff = $waktuSelesai - $waktuMulai;

        return $diff / 60;
    }
}

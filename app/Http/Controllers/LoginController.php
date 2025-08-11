<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\IpLogin;
use App\Models\Log;
use App\Models\PresensiHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.modern-login', [
            'title' => 'Login',
        ]);
    }

    public function authenticate(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $request->session()->regenerate();
            $ipAddress = $request->ip();

            if ($this->isAllowedIp($ipAddress)) {
                $ipId = IpLogin::where('alamat_ip', $ipAddress)->first()->id;

                // Cek apakah sudah ada presensi di hari yang sama
                $existingPresensi = PresensiHarian::where('pegawai_id', $user->id)
                ->whereDate('waktu_kehadiran', now()->toDateString())
                ->first();

                if (!$existingPresensi) {
                    // Buat presensi jika belum ada di hari ini
                    $presensi = PresensiHarian::create([
                        'pegawai_id' => $user->id,
                        'ip_login_id' => $ipId,
                        'waktu_kehadiran' => now(),
                    ]);

                    Log::create([
                        'pegawai_id' => $user->id,
                        'kegiatan_id' => $presensi->id,
                        'bobot' => 30,
                    ]);
                }

                return redirect()->intended('/dashboard');
            } else {
                return redirect()->intended('/dashboard')->withErrors(['ip' => 'Alamat IP Anda tidak tercatat di sistem. Presensi tidak dapat dilakukan.']);
            }
        }

        return back()->with('loginError', 'Your email or password is incorrect, please try again.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function isAllowedIp($ipAddress)
    {
        return IpLogin::where('alamat_ip', $ipAddress)->exists();
    }
}

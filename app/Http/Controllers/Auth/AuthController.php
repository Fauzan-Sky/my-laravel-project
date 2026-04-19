<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Penjual;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ══════════════════════════════════════════════════════════
    //  SHOW FORMS
    // ══════════════════════════════════════════════════════════

    public function showLogin()
    {
        if (Auth::guard('web')->check())     return redirect()->route('siswa.dashboard');
        if (Auth::guard('penjual')->check()) return redirect()->route('penjual.dashboard');
        if (Auth::guard('admin')->check())   return redirect()->route('admin.dashboard');

        return view('auth.login');
    }

    public function showLoginPenjual()
    {
        if (Auth::guard('penjual')->check()) return redirect()->route('penjual.dashboard');

        return view('auth.login_penjual');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // ══════════════════════════════════════════════════════════
    //  LOGIN
    // ══════════════════════════════════════════════════════════

    public function login(Request $request)
    {
        $role = $request->input('role', 'siswa');

        return match ($role) {
            'siswa'   => $this->loginSiswa($request),
            'penjual' => $this->loginPenjual($request),
            'admin'   => $this->loginAdmin($request),
            default   => back()->withErrors(['role' => 'Tipe akun tidak valid.']),
        };
    }

    private function loginSiswa(Request $request)
    {
        $request->validate([
            'nis'      => ['required', 'digits_between:10,12'],
            'password' => ['required'],
        ], [
            'nis.required'       => 'NIS wajib diisi.',
            'nis.digits_between' => 'NIS harus 10–12 digit angka.',
            'password.required'  => 'Password wajib diisi.',
        ]);

        $user = User::where('nis', $request->nis)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('nis', 'role'))
                ->withErrors(['nis' => 'NIS atau password salah.']);
        }

        if (! $user->is_active) {
            return back()->withErrors(['nis' => 'Akun kamu tidak aktif. Hubungi admin.']);
        }

        Auth::guard('web')->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('siswa.dashboard'))
            ->with('success', 'Selamat datang, ' . $user->nama_lengkap . '! 👋');
    }

    private function loginPenjual(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $penjual = Penjual::where('email', $request->email)->first();

        if (! $penjual || ! Hash::check($request->password, $penjual->password)) {
            return back()
                ->withInput($request->only('email', 'role'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        if (! $penjual->is_active) {
            return back()->withErrors(['email' => 'Akun penjual tidak aktif. Hubungi admin.']);
        }

        Auth::guard('penjual')->login($penjual, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('penjual.dashboard'))
            ->with('success', 'Selamat datang, ' . $penjual->nama . '! 🍳');
    }

    private function loginAdmin(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            return back()
                ->withInput($request->only('email', 'role'))
                ->withErrors(['email' => 'Email atau password admin salah.']);
        }

        Auth::guard('admin')->login($admin, $request->boolean('remember'));
        $admin->update(['last_login' => now()]);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Selamat datang, Admin ' . $admin->nama . '! 👨‍💼');
    }

    // ══════════════════════════════════════════════════════════
    //  REGISTER (hanya Siswa)
    // ══════════════════════════════════════════════════════════

    public function register(Request $request)
    {
        $request->validate([
            'nama_depan'    => ['required', 'string', 'max:50'],
            'nama_belakang' => ['required', 'string', 'max:50'],
            'nis'           => ['required', 'digits_between:10,12', 'unique:users,nis'],
            'kelas'         => ['required', 'string', 'max:10'],
            'no_hp'         => ['nullable', 'string', 'max:15'],
            'password'      => ['required', 'confirmed', Password::min(8)],
        ], [
            'nama_depan.required'    => 'Nama depan wajib diisi.',
            'nama_belakang.required' => 'Nama belakang wajib diisi.',
            'nis.required'           => 'NIS wajib diisi.',
            'nis.digits_between'     => 'NIS harus 10–12 digit angka.',
            'nis.unique'             => 'NIS sudah terdaftar.',
            'kelas.required'         => 'Kelas wajib dipilih.',
            'password.required'      => 'Password wajib diisi.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'nis'          => $request->nis,
            'nama_lengkap' => trim($request->nama_depan . ' ' . $request->nama_belakang),
            'kelas'        => $request->kelas,
            'no_hp'        => $request->no_hp,
            'password'     => Hash::make($request->password),
            'is_active'    => true,
        ]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->nama_lengkap . ' 🎉');
    }

    // ══════════════════════════════════════════════════════════
    //  LOGOUT
    // ══════════════════════════════════════════════════════════

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('penjual')->logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Kamu berhasil keluar.');
    }
}
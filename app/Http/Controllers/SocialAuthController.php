<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

/**
 * Login memakai akun Google / Microsoft / GitHub.
 *
 * KEAMANAN: sistem ini menyimpan data pribadi siswa, jadi akun sosial
 * TIDAK mendaftarkan pengguna baru. Hanya email yang SUDAH terdaftar di
 * tabel users (dibuat admin) yang boleh masuk.
 */
class SocialAuthController extends Controller
{
    /** Penyedia yang diizinkan => label tampilan. */
    public const PROVIDERS = [
        'google'    => 'Google',
        'microsoft' => 'Microsoft',
        'github'    => 'GitHub',
    ];

    public function redirect(string $provider): RedirectResponse
    {
        if ($gagal = $this->cekProvider($provider)) {
            return $gagal;
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(Request $request, string $provider): RedirectResponse
    {
        if ($gagal = $this->cekProvider($provider)) {
            return $gagal;
        }

        if ($request->has('error')) {
            return $this->tolak('Login dengan ' . self::PROVIDERS[$provider] . ' dibatalkan.');
        }

        try {
            $sosial = Socialite::driver($provider)->user();
        } catch (Throwable $e) {
            Log::warning('Login sosial gagal', ['provider' => $provider, 'error' => $e->getMessage()]);
            return $this->tolak('Login dengan ' . self::PROVIDERS[$provider] . ' gagal. Silakan coba lagi.');
        }

        $providerId = (string) $sosial->getId();
        $email      = strtolower(trim((string) $sosial->getEmail()));

        // 1) Akun sosial ini sudah pernah ditautkan.
        $tautan = DB::table('social_accounts')
            ->where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();

        $user = $tautan ? User::find($tautan->user_id) : null;

        // 2) Belum ditautkan: cocokkan dengan email pengguna terdaftar.
        if (! $user) {
            if ($email === '') {
                return $this->tolak('Akun ' . self::PROVIDERS[$provider] . ' tidak menyediakan alamat email.');
            }

            if (! $this->emailTerverifikasi($provider, $sosial)) {
                return $this->tolak('Email akun ' . self::PROVIDERS[$provider] . ' belum terverifikasi.');
            }

            $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

            if (! $user) {
                return $this->tolak('Email ' . $email . ' belum terdaftar di sistem. Hubungi administrator.');
            }

            DB::table('social_accounts')->updateOrInsert(
                ['provider' => $provider, 'provider_id' => $providerId],
                [
                    'user_id'    => $user->id,
                    'email'      => $email,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    private function cekProvider(string $provider): ?RedirectResponse
    {
        if (! array_key_exists($provider, self::PROVIDERS)) {
            return $this->tolak('Penyedia login tidak dikenal.');
        }

        if (! config("services.$provider.client_id") || ! config("services.$provider.client_secret")) {
            return $this->tolak('Login ' . self::PROVIDERS[$provider] . ' belum dikonfigurasi.');
        }

        return null;
    }

    /** Google memberi flag email_verified; GitHub hanya mengirim email primer terverifikasi. */
    private function emailTerverifikasi(string $provider, $sosial): bool
    {
        if ($provider === 'google') {
            $raw = (array) ($sosial->user ?? []);
            return filter_var($raw['email_verified'] ?? $raw['verified_email'] ?? false, FILTER_VALIDATE_BOOLEAN);
        }

        return true;
    }

    private function tolak(string $pesan): RedirectResponse
    {
        return redirect()->route('login')->withErrors(['email' => $pesan]);
    }
}
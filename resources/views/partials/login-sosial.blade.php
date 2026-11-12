{{-- Tombol login akun sosial. Selalu tampil; penyedia yang belum diisi di .env akan menampilkan pesan 'belum dikonfigurasi' --}}
@php
    $__sosial = [];
    if (\Illuminate\Support\Facades\Route::has('auth.social.redirect')) {
        foreach (['google' => 'Google', 'microsoft' => 'Microsoft', 'github' => 'GitHub'] as $k => $v) {
            // Tombol selalu tampil; jika belum dikonfigurasi, controller memberi pesan yang jelas.
            $__sosial[$k] = $v;
        }
    }
@endphp

@if (count($__sosial))
<style>
    .sosial-pemisah{display:flex;align-items:center;gap:12px;margin:22px 0 16px;color:#94a3b8;font-size:12px}
    .sosial-pemisah::before,.sosial-pemisah::after{content:"";flex:1;height:1px;background:#e2e8f0}
    .sosial-daftar{display:flex;flex-direction:column;gap:10px}
    .sosial-tombol{display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:12px 14px;border:1px solid #cbd5e1;border-radius:9px;background:#fff;color:#334155;font-size:14px;font-weight:bold;text-decoration:none;transition:background .2s,border-color .2s}
    .sosial-tombol:hover{background:#f8fafc;border-color:#94a3b8}
    .sosial-tombol:focus-visible{outline:3px solid #93c5fd;outline-offset:3px}
    .sosial-tombol svg{width:18px;height:18px;flex:none}
</style>

<div class="sosial-pemisah">atau masuk dengan</div>
<div class="sosial-daftar">
    @isset($__sosial['google'])
    <a class="sosial-tombol" href="{{ route('auth.social.redirect', 'google') }}">
        <svg viewBox="0 0 48 48" aria-hidden="true"><path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9.1 3.6l6.8-6.8C35.8 2.4 30.3 0 24 0 14.6 0 6.5 5.4 2.6 13.2l7.9 6.1C12.4 13.6 17.7 9.5 24 9.5z"/><path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3-2.3 5.5-4.8 7.2l7.6 5.9c4.4-4.1 7-10.1 7-17.6z"/><path fill="#FBBC05" d="M10.5 28.7a14.5 14.5 0 0 1 0-9.4l-7.9-6.1a24 24 0 0 0 0 21.6l7.9-6.1z"/><path fill="#34A853" d="M24 48c6.5 0 11.9-2.1 15.9-5.8l-7.6-5.9c-2.1 1.4-4.9 2.3-8.3 2.3-6.3 0-11.6-4.100-13.5-9.800l-7.9 6.1C6.500 42.600 14.600 48 24 48z"/></svg>
        Masuk dengan Google
    </a>
    @endisset
    @isset($__sosial['microsoft'])
    <a class="sosial-tombol" href="{{ route('auth.social.redirect', 'microsoft') }}">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#F25022" d="M1 1h10v10H1z"/><path fill="#7FBA00" d="M13 1h10v10H13z"/><path fill="#00A4EF" d="M1 13h10v10H1z"/><path fill="#FFB900" d="M13 13h10v10H13z"/></svg>
        Masuk dengan Microsoft
    </a>
    @endisset
    @isset($__sosial['github'])
    <a class="sosial-tombol" href="{{ route('auth.social.redirect', 'github') }}">
        <svg viewBox="0 0 16 16" aria-hidden="true"><path fill="#24292f" d="M8 0a8 8 0 0 0-2.5 15.600c.4.100.5-.200.500-.400v-1.500c-2.200.500-2.700-1-2.700-1-.4-.900-.9-1.200-.9-1.200-.7-.500.100-.500.100-.500.800.100 1.200.800 1.200.800.700 1.200 1.900.900 2.300.700.100-.500.300-.900.500-1.100-1.800-.200-3.600-.900-3.600-4 0-.900.300-1.600.800-2.100-.1-.200-.4-1 .1-2.100 0 0 .700-.200 2.200.800a7.500 7.500 0 0 1 4 0c1.500-1 2.200-.800 2.200-.800.400 1.100.2 1.900.1 2.100.500.600.800 1.300.800 2.100 0 3.100-1.900 3.800-3.600 4 .300.300.500.800.500 1.500v2.200c0 .200.100.500.600.400A8 8 0 0 0 8 0z"/></svg>
        Masuk dengan GitHub
    </a>
    @endisset
</div>
@endif
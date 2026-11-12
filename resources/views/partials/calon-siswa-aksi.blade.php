{{-- ========================================================================
     Aksi tambahan halaman Data Calon Siswa.
     Dipasang SETELAH script bawaan halaman (di bawah @include('partials.calon-siswa-data')).
     Tidak mengubah kode lama.

     Isi:
       0. "Quick Action" (bilah atas)               -> menu pintasan (sama seperti halaman Penerimaan)
       1. "+ Tambah Calon Siswa"                    -> formulir Pendaftaran Baru (menyimpan ke database)
       2. Ubah (pensil)                            -> disimpan ke database
       3. Hapus (satu / terpilih)                  -> dihapus dari database beserta berkasnya
       4. Verifikasi cepat / Ubah Status Massal    -> dialihkan ke halaman resminya
     ======================================================================== --}}
<script>
(function () {
  const URL_FORM   = "{{ route('pendaftaran') }}";
  const URL_VERIF  = "{{ route('verifikasi') }}";
  const URL_SELEKSI = "{{ route('seleksi') }}";
  const BASE       = "{{ url('/calon-siswa') }}";
  const CSRF       = "{{ csrf_token() }}";
  const URL_PENERIMAAN = "{{ route('penerimaan') }}";

  /* ---------- menu pintasan Quick Action ---------- */
  const css = document.createElement('style');
  css.textContent =
    '#qaMenu{position:absolute;right:28px;top:calc(100% + 8px);width:250px;background:#fff;border:1px solid #e5e9f0;border-radius:14px;' +
    'box-shadow:0 20px 50px rgba(11,31,58,.2);padding:8px;z-index:60;opacity:0;transform:translateY(-8px) scale(.97);pointer-events:none;transition:.25s}' +
    '#qaMenu.on{opacity:1;transform:none;pointer-events:auto}' +
    '#qaMenu a,#qaMenu button{display:flex;gap:9px;align-items:center;width:100%;padding:10px;border:0;background:none;border-radius:9px;' +
    'color:#0f1b2d;text-decoration:none;font:500 13px Inter,sans-serif;cursor:pointer;text-align:left}' +
    '#qaMenu a:hover,#qaMenu button:hover{background:#eef3fa}';
  document.head.appendChild(css);

  const topbar = document.querySelector('header.top, .top');
  let qaMenu = null;
  if (topbar && document.querySelector('.top [data-add]')) {
    qaMenu = document.createElement('div');
    qaMenu.id = 'qaMenu';
    qaMenu.innerHTML =
      '<a href="' + URL_FORM + '">📝 Pendaftaran Baru</a>' +
      '<button type="button" data-exp>⬇ Ekspor Data</button>' +
      '<a href="' + URL_VERIF + '">✔ Verifikasi Berkas</a>' +
      '<a href="' + URL_SELEKSI + '">📈 Status &amp; Seleksi</a>' +
      '<a href="' + URL_PENERIMAAN + '">🏠 Dashboard Penerimaan</a>';
    topbar.appendChild(qaMenu);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') qaMenu.classList.remove('on'); });
  }

  /* ---------- pembantu ---------- */
  async function api(url, method, body) {
    const r = await fetch(url, {
      method: method,
      headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/json' },
      body: body ? JSON.stringify(body) : undefined
    });
    let j = {}; try { j = await r.json(); } catch (x) {}
    if (!r.ok) {
      const first = j.errors ? Object.values(j.errors).flat()[0] : null;
      throw new Error(first || j.message || ('Terjadi kesalahan (kode ' + r.status + ')'));
    }
    return j;
  }
  function selesai(pesan) {                       // muat ulang halaman, lalu tampilkan pesan
    try { sessionStorage.setItem('flashCS', pesan); } catch (e) {}
    location.reload();
  }
  try {                                           // pesan setelah muat ulang
    const f = sessionStorage.getItem('flashCS');
    if (f) { sessionStorage.removeItem('flashCS'); setTimeout(function () { toast(f); }, 800); }
  } catch (e) {}

  /* ---------- rapikan formulir "Ubah" ---------- */
  const frm = document.getElementById('frm');
  if (frm) {
    // Status berkas, status seleksi, dan gelombang tidak diubah dari sini
    ['st', 'sel', 'g'].forEach(function (n) {
      const el = frm.elements[n];
      if (el) { el.disabled = true; el.title = 'Diatur di halaman Verifikasi Berkas / Status & Seleksi'; }
    });
    const j = frm.elements.jalur;                 // jalur yang dikenal sistem hanya 3
    if (j) Array.prototype.slice.call(j.options).forEach(function (o) { if (o.text === 'Prestasi Tahfidz') o.remove(); });

    frm.onsubmit = async function (e) {
      e.preventDefault();
      if (!edit) { toast('Gunakan tombol Tambah untuk menambah calon siswa'); return; }
      const f = Object.fromEntries(new FormData(frm));
      try {
        const res = await api(BASE + '/' + edit.id, 'PUT', {
          nama: String(f.name || '').trim(), nisn: f.nisn, jk: f.sex,
          sek: String(f.school || '').trim(), jalur: f.jalur
        });
        selesai(res.message);
      } catch (err) { toast(err.message); }
    };
  }

  /* ---------- klik tombol (fase capture: lebih dulu daripada kode bawaan) ---------- */
  document.addEventListener('click', async function (e) {
    const t = e.target;

    // 0. Tutup menu pintasan bila klik di luar; "Ekspor Data" dari menu
    if (qaMenu && !t.closest('#qaMenu') && !t.closest('.top [data-add]')) qaMenu.classList.remove('on');
    if (t.closest('#qaMenu [data-exp]')) {
      e.preventDefault(); e.stopPropagation();
      qaMenu.classList.remove('on');
      const ex = document.getElementById('exp'); if (ex) ex.click();
      return;
    }

    // 0. Quick Action (bilah atas) -> buka / tutup menu pintasan
    if (qaMenu && t.closest('.top [data-add]')) {
      e.preventDefault(); e.stopPropagation();
      qaMenu.classList.toggle('on');
      return;
    }

    // 1. Tambah -> formulir pendaftaran sungguhan
    if (t.closest('[data-add]')) {
      e.preventDefault(); e.stopPropagation();
      window.location.href = URL_FORM;
      return;
    }

    // 3a. Hapus satu data
    const hapus = t.closest('[data-a="d"]');
    if (hapus) {
      e.preventDefault(); e.stopPropagation();
      const id = +hapus.dataset.id;
      const r = D.find(function (x) { return x.id == id; });
      if (!r) return;
      if (!confirm('Hapus "' + r.name + '" beserta berkasnya dari database?\nTindakan ini tidak bisa dibatalkan.')) return;
      try { const res = await api(BASE + '/' + id, 'DELETE'); selesai(res.message); }
      catch (err) { toast(err.message); }
      return;
    }

    // 3b. Hapus terpilih
    if (t.closest('#bDel')) {
      e.preventDefault(); e.stopPropagation();
      const ids = Array.from(sel);
      if (!ids.length) return;
      if (!confirm('Hapus ' + ids.length + ' calon siswa terpilih beserta berkasnya dari database?\nTindakan ini tidak bisa dibatalkan.')) return;
      const hasil = await Promise.allSettled(ids.map(function (id) { return api(BASE + '/' + id, 'DELETE'); }));
      const ok = hasil.filter(function (h) { return h.status === 'fulfilled'; }).length;
      selesai(ok + ' data dihapus' + (ids.length - ok ? ', ' + (ids.length - ok) + ' gagal' : ''));
      return;
    }

    // 4. Verifikasi cepat -> halaman Verifikasi Berkas
    if (t.closest('[data-a="q"]') || t.closest('#bVer')) {
      e.preventDefault(); e.stopPropagation();
      toast('Verifikasi dilakukan di halaman Verifikasi Berkas');
      setTimeout(function () { window.location.href = URL_VERIF; }, 1200);
      return;
    }

    // 4. Ubah status massal -> halaman Status & Seleksi
    if (t.closest('#bSt')) {
      e.preventDefault(); e.stopPropagation();
      toast('Status seleksi diatur di halaman Status & Seleksi');
      setTimeout(function () { window.location.href = URL_SELEKSI; }, 1200);
    }
  }, true);
})();
</script>
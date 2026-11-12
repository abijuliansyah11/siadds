{{-- Menyambungkan formulir Pendaftaran Baru ke database. Dipasang setelah script bawaan halaman; tidak mengubah kode lama. --}}
<script>
(function () {
  const URL_SIMPAN = "{{ route('pendaftaran.simpan') }}";
  const CSRF = "{{ csrf_token() }}";
  const FILES = {};            // objek berkas asli (halaman lama hanya menyimpan namanya)
  let PID = null, NO = null;   // id & nomor registrasi dari server

  // Tangkap berkas sebelum diproses halaman lama (fase capture)
  document.addEventListener('change', function (e) {
    const f = e.target.files && e.target.files[0];
    if (!f || f.size > 2 * 1024 * 1024) return;
    if (e.target.id === 'pf') FILES.foto = f;
    if (e.target.id === 'df' && e.target.dataset.for) FILES[e.target.dataset.for] = f;
  }, true);
  document.addEventListener('click', function (e) {
    if (e.target.closest('#delph')) delete FILES.foto;
  }, true);

  async function kirim(status) {
    const fd = new FormData();
    fd.append('status', status);
    if (PID) fd.append('id', PID);
    Object.keys(V).forEach(k => { if (V[k] !== undefined && V[k] !== null) fd.append(k, V[k]); });
    if (FILES.foto) fd.append('foto', FILES.foto);
    ['akta', 'kk', 'ijazah', 'kip'].forEach(k => { if (FILES[k]) fd.append('dok_' + k, FILES[k]); });

    const r = await fetch(URL_SIMPAN, { method: 'POST', body: fd,
      headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });
    let j = {}; try { j = await r.json(); } catch (x) {}
    if (!r.ok) {
      const err = new Error(j.message || 'Gagal menyimpan (kode ' + r.status + ')');
      err.errors = j.errors || {};
      throw err;
    }
    PID = j.id; NO = j.no_registrasi;
    tampilNomor();
    return j;
  }

  function tampilNomor() {
    if (!NO) return;
    const a = document.querySelector('.reg b'); if (a) a.textContent = NO;
    const b = document.querySelector('#dlg > b'); if (b) b.textContent = NO;
  }

  function tampilError(e) {
    const keys = Object.keys(e.errors || {});
    if (!keys.length) { toast(e.message); return; }
    const k = keys[0], msg = e.errors[k][0];
    if (k === 'foto') { cur = 0; pane(); }
    else if (k.indexOf('dok_') === 0) { cur = 4; pane(); const d = document.getElementById('derr'); if (d) d.textContent = msg; }
    else {
      const si = ST.findIndex(s => s.f.some(f => f.k === k));
      if (si >= 0) {
        cur = si; maxR = Math.max(maxR, si); pane();
        const w = document.querySelector('[data-f="' + k + '"]');
        if (w) { w.classList.add('bad'); const er = w.querySelector('.err'); if (er) er.textContent = msg; }
      }
    }
    toast(msg);
  }

  // ---- Simpan Draft: tetap simpan di browser, lalu simpan juga ke database ----
  const _draft = draft, _next = next;
  draft = async function () {
    _draft();
    if (!V.nama || String(V.nama).trim().length < 3) { toast('Isi nama lengkap dulu agar draft bisa disimpan ke database'); return; }
    try { const j = await kirim('draft'); toast('Draft tersimpan di database • ' + j.no_registrasi + ' • ' + j.kelengkapan + '% lengkap'); }
    catch (e) { tampilError(e); }
  };

  // ---- Simpan & Lanjutkan: langkah 1-4 seperti biasa, langkah 5 mengirim ke database ----
  next = async function () {
    if (cur < 4) return _next();
    if (!stepValid(cur, true)) { toast('Lengkapi isian yang ditandai merah'); return; }
    const btn = document.getElementById('next'); if (btn) btn.disabled = true;
    try {
      await kirim('terkirim');
      done.add(cur); summary(); stepper(); draftClear();
      document.getElementById('dlg').showModal();
    } catch (e) { tampilError(e); }
    finally { const b = document.getElementById('next'); if (b) b.disabled = false; }
  };
})();
</script>
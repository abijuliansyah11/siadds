{{-- Menyambungkan halaman Verifikasi Berkas ke database. Dipasang SETELAH script bawaan halaman; kode lama tidak diubah. --}}
<script>
(function(){
const V=@json($vdata ?? []);
const URL_U="{{ url('/verifikasi') }}",TOK="{{ csrf_token() }}";

/* Pratinjau berkas asli (menggantikan lembar contoh) */
window.paper=function(){const s=S[cur],d=s.docs[dc];$('#vt').textContent=d.t;$('#vm').textContent='Berkas: '+d.file+' • '+d.size;let b,st='';
 if(dc==4){b=`<div class="hd">FORMULIR PENDAFTARAN PPDB<b>MAS YPI SUMBER HARJO</b>${esc(s.reg)}</div><table>${s.form.map(r=>`<tr><td>${esc(r[0])}</td><td>: ${esc(r[1]||'-')}</td></tr>`).join('')}</table>${s.kip?`<p style="margin-top:14px"><a href="${s.kip.url}" target="_blank" rel="noopener">📎 Buka KIP / PKH (${esc(s.kip.name)})</a></p>`:'<p class="mu" style="margin-top:14px">KIP / PKH: tidak dilampirkan.</p>'}`}
 else if(!d.url)b='<p class="mu" style="text-align:center;padding:60px 0">Berkas belum diunggah.</p>';
 else if(/\.pdf(\?|$)/i.test(d.url)){b=`<iframe src="${d.url}" title="${esc(d.t)}" style="width:100%;height:660px;border:0"></iframe>`;st='padding:0;'}
 else b=`<img src="${d.url}" alt="${esc(d.t)}" style="max-width:100%;display:block;margin:0 auto">`;
 $('#vw').innerHTML=`<div class="paper" id="pp" style="${st}">${b}</div>`;zoom()};

/* Tanggal daftar asli */
const _all=window.all;window.all=function(){_all();const s=S[cur],e=[...document.querySelectorAll('#stu .pl span')].find(x=>x.textContent.startsWith('Terdaftar'));if(e&&s)e.textContent='Terdaftar: '+s.tgl_daftar};

/* Unduh berkas asli */
window.addEventListener('click',e=>{const x=e.target.closest&&e.target.closest('[data-dl],#dw');if(!x)return;e.stopPropagation();e.preventDefault();
 const d=S[cur]&&S[cur].docs[x.dataset.dl!==undefined?+x.dataset.dl:dc];if(!d||!d.url)return toast('Dokumen ini tidak memiliki berkas untuk diunduh');
 const a=document.createElement('a');a.href=d.url;a.download=d.file;a.target='_blank';document.body.appendChild(a);a.click();a.remove()},true);

/* Simpan ke database setiap Simpan / Kembalikan / Terima */
function persist(s){if(!s||!s.dbid)return;
 fetch(URL_U+'/'+s.dbid,{method:'PUT',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':TOK},
  body:JSON.stringify({docs:s.docs.map(d=>({st:d.st,cat:d.cat||'',note:d.note||'',int:d.int||''})),ret:!!s.ret,log:s.log.slice(0,40)})})
 .then(r=>r.ok?r.json():Promise.reject(r)).catch(r=>toast(r&&r.status==419?'Sesi habis. Muat ulang halaman lalu ulangi.':'Gagal menyimpan ke database. Coba lagi.'))}
['save','ret','acc'].forEach(n=>{const f=window[n];window[n]=function(){const s=S[cur];f();persist(s)}});

/* Nama pengguna yang login pada catatan riwayat (menggantikan nama tetap di kode lama) */
const NAMA=esc(@json(auth()->user()->name ?? 'Admin'));
const _al=window.addLog;window.addLog=function(h,c,i){_al(String(h).split('Ahmad Fauzi').join(NAMA),c,i)};

/* Label filter "Dokumen" disesuaikan dengan slot berkas yang sebenarnya */
const LBL={0:'Kartu Keluarga (KK)',1:'Akta Kelahiran',2:'SKL / Ijazah',3:'Pas Foto',4:'Data Formulir'};
document.querySelectorAll('#fD option').forEach(o=>{if(o.value in LBL)o.textContent=LBL[o.value]});

/* Ganti data contoh dengan data database */
S.splice(0,S.length,...V);
if(!V.length){cur=0;kfirst=true;kpis();info();queue();
 ['#docs','#vw','#dcard','#tl'].forEach(x=>$(x).innerHTML='');$('#vt').textContent='-';$('#vm').textContent='';$('#rg').textContent='';
 $('#stu').innerHTML='<div class="mu" style="padding:30px;text-align:center;line-height:1.7"><b style="color:var(--tx)">Belum ada pendaftar yang siap diverifikasi.</b><br>Hanya pendaftaran berstatus <b>Terkirim</b> yang masuk antrean. Draft belum tampil.</div>';return}
cur=0;kfirst=true;pick(0);
})();
</script>
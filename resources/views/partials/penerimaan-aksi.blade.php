{{-- Tambahan interaksi Dashboard Penerimaan. Dipasang setelah script bawaan halaman; tidak mengubah kode lama. --}}
<style>
.kpi{cursor:pointer;transition:transform .3s,box-shadow .3s}.kpi:hover{transform:translateY(-4px);box-shadow:0 14px 34px rgba(11,31,58,.1)}#tb tr{cursor:pointer}.agenda,.kv{cursor:pointer;transition:transform .25s}.agenda:hover,.kv:hover{transform:translateX(4px)}.folder{cursor:pointer}
.sx-ov{position:fixed;inset:0;z-index:80;background:rgba(11,31,58,.45);backdrop-filter:blur(5px);opacity:0;pointer-events:none;transition:opacity .3s;display:grid;place-items:center;padding:16px}.sx-ov.on{opacity:1;pointer-events:auto}
.sx-box{background:#fff;border-radius:18px;width:min(540px,100%);max-height:90vh;overflow:auto;padding:22px;box-shadow:0 30px 80px rgba(11,31,58,.35);transform:translateY(30px) scale(.95);transition:transform .45s cubic-bezier(.2,.8,.2,1)}.sx-ov.on .sx-box{transform:none}
.sx-ov.dr{place-items:stretch end;padding:0}.dr .sx-box{width:min(460px,100%);max-height:none;height:100%;border-radius:18px 0 0 18px;transform:translateX(100%)}.dr.on .sx-box{transform:none}
.sx-h{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}.sx-h h3{margin:0;font-size:18px}.sx-x{border:0;background:#eef3fa;width:32px;height:32px;border-radius:50%;cursor:pointer;transition:.25s}.sx-x:hover{background:#fee2e2;transform:rotate(90deg)}
.sx-li{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:11px 12px;border:1px solid #e5e9f0;border-radius:12px;margin-bottom:8px;animation:sxin .5s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--i,0)*50ms);transition:.25s}.sx-li.c{cursor:pointer}.sx-li.c:hover{background:#f6f9fe;transform:translateX(4px)}.sx-li small{display:block;color:#64748b}@keyframes sxin{from{opacity:0;transform:translateX(24px)}}
.sx-in{width:100%;margin:6px 0 10px;padding:11px 12px;border:1.5px solid transparent;border-radius:10px;background:#eef3fa;font:inherit;outline:0;transition:.25s}.sx-in:focus{border-color:#0f7a4f;background:#fff;box-shadow:0 0 0 4px rgba(15,122,79,.12)}.sx-er{border-color:#dc2626!important;animation:sxsk .4s}@keyframes sxsk{25%{transform:translateX(-5px)}75%{transform:translateX(5px)}}
.sx-a{display:flex;justify-content:flex-end;gap:8px;margin-top:14px;flex-wrap:wrap}.sx-b{border:0;padding:11px 16px;border-radius:10px;font:600 13px Inter,sans-serif;cursor:pointer;background:#eef3fa;color:#0f1b2d;transition:.25s}.sx-b:hover{transform:translateY(-2px)}.sx-b.g{background:#0f7a4f;color:#fff}
.sx-mn{position:absolute;right:0;top:calc(100% + 8px);width:250px;background:#fff;border:1px solid #e5e9f0;border-radius:14px;box-shadow:0 20px 50px rgba(11,31,58,.2);padding:8px;z-index:50;opacity:0;transform:translateY(-8px) scale(.97);pointer-events:none;transition:.25s}.sx-mn.on{opacity:1;transform:none;pointer-events:auto}
.sx-mn a,.sx-mn button{display:flex;gap:9px;align-items:center;width:100%;padding:10px;border:0;background:none;border-radius:9px;color:#0f1b2d;text-decoration:none;font:500 13px Inter,sans-serif;cursor:pointer;text-align:left}.sx-mn a:hover,.sx-mn button:hover{background:#eef3fa}
.sx-pb{height:8px;border-radius:8px;background:#e2e8f0;overflow:hidden;margin-top:8px}.sx-pb i{display:block;height:100%;width:0;background:linear-gradient(90deg,#0f7a4f,#34d399);transition:width 1s cubic-bezier(.2,.8,.2,1)}
</style>
<div class="sx-ov" id="sxOv"><div class="sx-box" role="dialog" aria-modal="true"></div></div>
<script>
(function(){
const qa=s=>[...document.querySelectorAll(s)],ESC=esc;
const R={verifikasi:"{{ route('verifikasi') }}",seleksi:"{{ route('seleksi') }}",calon:"{{ route('calon') }}",pendaftaran:"{{ route('pendaftaran') }}"};
const LS=k=>{try{return JSON.parse(localStorage.getItem(k))||[]}catch(e){return[]}},SV=(k,v)=>{try{localStorage.setItem(k,JSON.stringify(v))}catch(e){}};
let SIS=LS('siadds_siswa'),KON=LS('siadds_konversi');
/* --- Perbaikan: ID "chart" bentrok dengan ikon sidebar --- */
const sym=document.querySelector('symbol#chart'),cv=document.querySelector('.chartbox svg');
if(sym&&cv){sym.innerHTML='<path d="M3 3v18h18M7 15l4-4 3 3 5-6"/>';cv.id='chartTren';
 window.chart=(0,eval)('('+chart.toString().replace("$('#chart')","$('#chartTren')")+')');chart((qa('#seg .on')[0]||{dataset:{r:30}}).dataset.r);
 cv.addEventListener('mouseover',e=>{const c=e.target.closest('circle');if(!c)return;const t=$('#tip'),b=$('.chartbox').getBoundingClientRect(),r=c.getBoundingClientRect();t.textContent=c.dataset.t;t.style.left=(r.left-b.left+r.width/2)+'px';t.style.top=(r.top-b.top)+'px';t.style.opacity=1});cv.addEventListener('mouseout',()=>$('#tip').style.opacity=0)}
/* --- Modal / drawer --- */
const ov=$('#sxOv'),box=ov.firstElementChild;
function open(t,h,dr){ov.classList.toggle('dr',!!dr);box.innerHTML=`<div class="sx-h"><h3>${t}</h3><button class="sx-x" aria-label="Tutup">✕</button></div>${h}`;ov.classList.add('on');box.scrollTop=0;box.querySelector('.sx-x').onclick=close;const f=box.querySelector('input');f&&setTimeout(()=>f.focus(),300)}
function close(){ov.classList.remove('on')}ov.addEventListener('click',e=>{if(e.target==ov)close()});document.addEventListener('keydown',e=>{if(e.key=='Escape'){close();mn.classList.remove('on')}});
const row=(h,i,c)=>`<div class="sx-li ${c?'c':''}" style="--i:${i}" ${c||''}>${h}</div>`,kv=(a,b,i)=>row(`<span>${a}</span><b style="text-align:right">${b}</b>`,i);
const chip=f=>{document.querySelector(`[data-f=${f}]`).click();$('#tblcard').scrollIntoView({behavior:'smooth',block:'start'})};
/* --- Filter TA & Gelombang --- */
const sel=qa('.tools select'),pill=document.querySelector('.head .pill');
const PRE={g1:{tot:248,T:156,M:57,P:23,R:12,L:112},g2:{tot:96,T:31,M:40,P:15,R:10,L:38},old:{tot:231,T:220,M:0,P:3,R:8,L:160}};
function preset(){const k=sel[0].selectedIndex==1?'old':sel[1].selectedIndex==1?'g2':'g1',p=PRE[k];Object.assign(S,p);stats(true);view();
 const kp=qa('.kpi')[3];kp.querySelector('strong').textContent=p.L;kp.querySelector('.tag').textContent=p.L+' / 160 ('+Math.round(p.L/160*100)+'%)';
 pill.textContent=k=='old'?'● TA 2025/2026 Selesai':k=='g2'?'● Gelombang 2':'● Gelombang 1 Aktif';toast('Menampilkan '+sel[0].value+' — '+sel[1].value+' (data contoh)')}
sel.forEach(s=>s.addEventListener('change',preset));
/* --- Kartu KPI --- */
qa('.kpi').forEach((c,i)=>c.addEventListener('click',()=>{if(i<3)return chip(['all','T','M'][i]);const L=document.querySelectorAll('.kpi')[3].querySelector('strong').textContent;
 open('Kapasitas Rombel PPDB',`<div style="font-size:44px;font-weight:800">${L} <small style="font-size:16px;color:#64748b">/ 160 kursi</small></div><div class="sx-pb"><i id="cb"></i></div><p class="mu" style="margin:10px 0">Sisa kuota: ${160-L} kursi (${Math.round((160-L)/160*100)}%). Target sidang pleno 02 Juni 2026.</p><div class="sx-a"><a class="sx-b g" style="text-decoration:none" href="${R.seleksi}">Buka Status & Seleksi</a></div>`);setTimeout(()=>$('#cb').style.width=L/160*100+'%',200)}));
/* --- Detail baris pendaftar --- */
const find=r=>D.find(x=>x.reg==r);
$('#tb').addEventListener('click',e=>{const tr=e.target.closest('tr');if(!tr||!tr.children[1])return;const x=find(tr.children[1].textContent);if(!x)return;
 open('Detail Pendaftar',[['No. Registrasi',x.reg],['Nama',ESC(x.name)],['NISN',x.nisn],['Asal Sekolah',ESC(x.school)],['Jalur',x.jalur],['Tgl Masuk',fmt(x.date)],['Status Berkas',`<span class="st ${ST[x.st][1]}">${ST[x.st][0]}</span>`]].map((r,i)=>kv(r[0],r[1],i)).join('')+`<div class="sx-a"><button class="sx-b" data-s="P">Perlu Perbaikan</button><button class="sx-b" data-s="M">Menunggu</button><button class="sx-b g" data-s="T">Tandai Terverifikasi</button></div>`);
 box.onclick=ev=>{const n=ev.target.dataset.s;if(!n||n==x.st)return;S[x.st]--;S[n]++;x.st=n;stats(false);view();$('#feed').insertAdjacentHTML('afterbegin',feed(`Status <b>${ESC(x.name)}</b> diubah menjadi <b>${ST[n][0]}</b>.`,'Baru saja','#2563eb'));close();toast('Status diperbarui: '+ST[n][0])}});
/* --- Folder arsip --- */
document.querySelector('.folder').addEventListener('click',e=>{e.preventDefault();open('Direktori Arsip Digital TA 2026',[['Kartu Keluarga (KK)',.98],['Akta Kelahiran',.95],['Ijazah / SKL',.88],['Pas Foto 3x4',.92]].map((f,i)=>row(`<div style="flex:1">📁 <b>${f[0]}</b><span style="float:right">${Math.round(S.tot*f[1])} berkas</span><div class="sx-pb"><i data-w="${f[1]*100}"></i></div></div>`,i)).join(''),1);setTimeout(()=>qa('[data-w]').forEach(b=>b.style.width=b.dataset.w+'%'),250)});
/* --- Agenda + kalender (.ics) --- */
function agenda(t,d,ds){open(t,`<p class="mu" style="line-height:1.6">${ds}</p><div class="sx-a"><button class="sx-b" id="ag0">Tutup</button><button class="sx-b g" id="ag1">Tambah ke Kalender (.ics)</button></div>`);$('#ag0').onclick=close;
 $('#ag1').onclick=()=>{const s=`BEGIN:VCALENDAR\r\nVERSION:2.0\r\nBEGIN:VEVENT\r\nUID:${d}@siadds\r\nDTSTAMP:20261016T000000Z\r\nDTSTART;VALUE=DATE:${d}\r\nSUMMARY:${t}\r\nEND:VEVENT\r\nEND:VCALENDAR`;const a=document.createElement('a');a.href=URL.createObjectURL(new Blob([s],{type:'text/calendar'}));a.download='agenda-ppdb.ics';a.click();toast('Agenda diunduh')}}
const AG=[['Batas Akhir Gelombang 1','20260531','Pendaftaran jalur reguler & prestasi ditutup 31 Mei 2026 pukul 23:59 WIB.'],['Ujian CBT & Wawancara','20260603','Ujian CBT dan wawancara calon siswa pada 03 Juni 2026.'],['Pengumuman Kelulusan','20260610','Pengumuman kelulusan PPDB pada 10 Juni 2026.']];
[document.querySelector('.agenda'),...qa('.kv')].forEach((e,i)=>e.addEventListener('click',()=>agenda(...AG[i])));
/* --- Quick Action --- */
const qb=document.querySelector('.top [data-open]');qb.parentNode.style.position='relative';const mn=document.createElement('div');mn.className='sx-mn';
mn.innerHTML=`<button data-q="d">👤 Pendaftaran Baru</button><button data-q="s">＋ Tambah Siswa Baru</button><button data-q="e">⬇ Ekspor Laporan</button><button data-q="r">✔ Ruang Verifikasi</button><a href="${R.seleksi}">📈 Status & Seleksi</a><a href="${R.calon}">👥 Data Calon Siswa</a>`;qb.after(mn);
qb.onclick=e=>{e.stopPropagation();mn.classList.toggle('on')};document.addEventListener('click',e=>{if(!mn.contains(e.target))mn.classList.remove('on')});
mn.addEventListener('click',e=>{const q=e.target.dataset.q;if(!q)return;mn.classList.remove('on');({d:()=>dlg.showModal(),s:formSiswa,e:()=>$('#exp').click(),r:()=>$('#goRev').click()})[q]()});
/* --- Sidebar --- */
const AKT=[['Anisa Rahmawati','X-B','8078121101','P'],['Dimas Pratama','X-A','8078121102','L'],['Bagas Saputra','XI-IPS 1','8059124409','L'],['Zaskia Nur Azizah','XI-IPA','8078921438','P']],ALM=[['Siti Khoirun Nisa','Lulus 2023','7956121001','P'],['Ahmad Zulkifli','Lulus 2023','7956121002','L']];
const all=()=>[...AKT,...SIS.map(s=>[s.nama,s.kelas,s.nisn,s.jk])];
function list(t,f){open(t,`<input class="sx-in" id="sq" placeholder="Cari nama atau NISN...">`+'<div id="sl"></div>',1);const dr=q=>{$('#sl').innerHTML=f().filter(a=>(a[0]+a[2]).toLowerCase().includes(q.toLowerCase())).map((a,i)=>row(`<div><b>${ESC(a[0])}</b><small>${ESC(a[1])} • NISN ${a[2]}</small></div><span class="pill">${a[3]=='L'?'L':'P'}</span>`,i,`data-n="${a[2]}"`)).join('')||'<p class="mu">Tidak ditemukan.</p>'};dr('');$('#sq').oninput=e=>dr(e.target.value);
 $('#sl').onclick=e=>{const r=e.target.closest('[data-n]');if(!r)return;const a=f().find(x=>x[2]==r.dataset.n);open('Detail Profil Siswa',[['Nama',ESC(a[0])],['Kelas / Status',ESC(a[1])],['NISN',a[2]],['Jenis Kelamin',a[3]=='L'?'Laki-laki':'Perempuan']].map((r,i)=>kv(r[0],r[1],i)).join('')+'<div class="sx-a"><button class="sx-b" id="bk">← Kembali</button></div>',1);$('#bk').onclick=()=>list(t,f)}}
function formSiswa(){open('Tambah Siswa Baru','<label>Nama Lengkap *</label><input class="sx-in" id="fN" maxlength="80"><label>NISN (10 digit) *</label><input class="sx-in" id="fS" maxlength="10" inputmode="numeric"><label>Kelas</label><select class="sx-in" id="fK"><option>X-A</option><option>X-B</option><option>XI-IPA</option><option>XI-IPS 1</option><option>XII-MIA</option></select><label>Jenis Kelamin</label><select class="sx-in" id="fG"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select><div class="sx-a"><button class="sx-b" id="fC">Batal</button><button class="sx-b g" id="fO">Simpan</button></div>');$('#fC').onclick=close;
 $('#fO').onclick=()=>{const n=$('#fN'),s=$('#fS');let ok=1;[n,s].forEach(e=>e.classList.remove('sx-er'));const bad=(e,m)=>{ok=0;e.offsetWidth;e.classList.add('sx-er');toast(m)};if(n.value.trim().length<3)bad(n,'Nama minimal 3 huruf');if(!/^\d{10}$/.test(s.value))bad(s,'NISN harus 10 digit');else if(all().some(a=>a[2]==s.value))bad(s,'NISN sudah terdaftar');if(!ok)return;
  SIS.push({nama:n.value.trim(),nisn:s.value,kelas:$('#fK').value,jk:$('#fG').value});SV('siadds_siswa',SIS);close();toast('Siswa baru ditambahkan')}}
function konv(){const L=()=>D.filter(x=>x.st=='T'&&!KON.includes(x.reg));open('Daftar Ulang & Konversi','<p class="mu" style="margin-bottom:12px">Calon berstatus Terverifikasi dapat dikonversi menjadi siswa aktif.</p><div id="kl"></div>',1);const dr=()=>{$('#kl').innerHTML=L().map((x,i)=>row(`<div><b>${ESC(x.name)}</b><small>${x.reg}</small></div><button class="sx-b g" data-k="${x.reg}">Konversi</button>`,i)).join('')||'<p class="mu">Tidak ada calon yang siap dikonversi.</p>'};dr();$('#kl').onclick=e=>{const k=e.target.dataset.k;if(!k)return;const x=find(k);KON.push(k);SV('siadds_konversi',KON);SIS.push({nama:x.name,nisn:x.nisn,kelas:'X (Baru)',jk:x.sex});SV('siadds_siswa',SIS);$('#feed').insertAdjacentHTML('afterbegin',feed(`<b>${ESC(x.name)}</b> dikonversi menjadi siswa aktif.`,'Baru saja','#0f7a4f'));toast('Konversi berhasil');dr()}}
const MAP={'Data Siswa Aktif':()=>list('Data Siswa Aktif',all),'Detail Profil Siswa':()=>list('Pilih Siswa',all),'Data Alumni':()=>list('Data Alumni',()=>ALM),'Tambah Siswa Baru':formSiswa,'Daftar Ulang & Konversi':konv,'Direktori Arsip Digital':()=>document.querySelector('.folder').click()};
qa('.side a[href="#"]').forEach(a=>a.addEventListener('click',e=>{e.preventDefault();(MAP[a.textContent.trim()]||(()=>toast('Menu ini tersedia di Dashboard Utama')))()}));
})();
</script>
{{-- Menyambungkan halaman Status & Seleksi ke database. Dipasang SETELAH script bawaan halaman; kode lama tidak diubah. --}}
<style>
.sx-nr{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin:14px 0}.sx-nr label{font-size:12px;font-weight:600}
.sx-nr input,.sx-nr select{width:100%;margin-top:5px;padding:10px 12px;border:1.5px solid transparent;border-radius:10px;background:#eef3fa;font:inherit;outline:0;transition:.25s}
.sx-nr input:focus,.sx-nr select:focus{border-color:#0f7a4f;background:#fff;box-shadow:0 0 0 4px rgba(15,122,79,.12)}.sx-nr input:disabled,.sx-nr select:disabled{opacity:.6}
</style>
<script>
(function(){
const V=@json($sdata ?? []),LG=@json($slogs ?? []),NAMA=@json(auth()->user()->name ?? 'Admin');
const U="{{ url('/seleksi') }}",TOK="{{ csrf_token() }}",OLD='Ahmad Fauzi, S.Pd.';
const hdr={'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':TOK};
const nm=h=>String(h).split(OLD).join(esc(NAMA));
function gagal(m){toast(m||'Gagal menyimpan ke database. Memuat ulang…');setTimeout(()=>location.reload(),1800)}
function kirim(url,method,body,ok){fetch(url,{method,headers:hdr,body:JSON.stringify(body)}).then(r=>r.json().then(j=>({r,j}))).then(({r,j})=>{if(!r.ok||!j.ok)return gagal(j.message||(r.status==419?'Sesi habis. Muat ulang halaman.':null));ok&&ok(j)}).catch(()=>gagal())}
function newLogs(n0){const a=LOGS.slice(0,Math.max(0,LOGS.length-n0));a.forEach(l=>l[0]=nm(l[0]));return a.map(l=>({h:l[0],c:l[2]}))}
function persist(x,n0){kirim(U+'/'+x.id,'PUT',{sel:x.sel,note:x.note||'',lock:!!x.lock,score:x.score||0,zon:x.zon||1,log:newLogs(n0)})}

/* Isian nilai rapor & zonasi (form pendaftaran tidak memuat nilai rapor) */
const _panel=window.panel;window.panel=function(){_panel();const x=D.find(y=>y.id==cur),o=$('#ops');if(!x||!o)return;
 o.previousElementSibling.insertAdjacentHTML('beforebegin',`<div class="sx-nr"><label>Nilai Rapor (0–100)<input id="nr" type="number" step="0.01" min="0" max="100" value="${x.score||''}" placeholder="Isi nilai rapor" ${x.lock?'disabled':''}></label><label>Prioritas Zonasi<select id="zn" ${x.lock?'disabled':''}>${[1,2,3].map(n=>`<option ${x.zon==n?'selected':''}>${n}</option>`).join('')}</select></label></div>`)};
document.addEventListener('input',e=>{if(e.target.id!=='nr')return;const x=D.find(y=>y.id==cur);x.score=Math.min(100,Math.max(0,parseFloat(e.target.value)||0));const c=$('#dcard').querySelectorAll('.ci')[2];if(c){c.classList.toggle('no',x.score<75);c.querySelector('i').textContent=x.score>=75?'✓':'!';c.querySelector('b').textContent=x.score.toFixed(2)}});
document.addEventListener('change',e=>{if(e.target.id!=='zn')return;const x=D.find(y=>y.id==cur);x.zon=+e.target.value;const c=$('#dcard').querySelectorAll('.ci')[3];if(c)c.querySelector('b').textContent='Prioritas '+x.zon});

/* Kunci & Tetapkan */
const _lock=window.lock;window.lock=function(x){const was=x.lock,n0=LOGS.length;_lock(x);if(!was&&x.lock){x.off=NAMA;persist(x,n0);logs();table()}};

/* Draft, Buka Kunci, dan Hasil Massal */
let N0=0,SNAP=null;
document.addEventListener('click',e=>{N0=LOGS.length;const b=e.target.closest&&e.target.closest('button');if(b&&b.id==='mOk')SNAP=new Map(D.filter(y=>sel.has(y.id)).map(y=>[y.id,y.d.getTime()]))},true);
document.addEventListener('click',e=>{const b=e.target.closest&&e.target.closest('button');if(!b)return;const x=D.find(y=>y.id==cur);
 if(b.id==='dr'&&x&&!x.lock)persist(x,LOGS.length);
 if(b.id==='unl'&&x){persist(x,N0);logs()}
 if(b.id==='mOk'&&SNAP){const ids=[...SNAP.keys()].filter(i=>{const y=D.find(z=>z.id==i);return y&&y.d.getTime()!==SNAP.get(i)});
  if(ids.length){const v=D.find(z=>z.id==ids[0]).sel;ids.forEach(i=>D.find(z=>z.id==i).off=NAMA);const lg=newLogs(N0);
   kirim(U+'/massal','POST',{ids,sel:v,log:lg},j=>{if(j.updated.length!==ids.length)gagal('Sebagian tidak tersimpan, menyinkronkan…')});logs();table()}
  SNAP=null}});

/* Pengaman: panggilan setCur(1) bawaan halaman tidak boleh memilih siswa yang tidak ada */
let skip1=true;const _sc=window.setCur;
window.setCur=function(id){if(skip1){skip1=false;if(id==1)id=cur}if(!D.some(x=>x.id==id))id=D.length?D[0].id:null;if(id===null)return;_sc(id)};

/* Ganti data contoh dengan data database */
sel.clear();LOGS.splice(0,LOGS.length,...LG.map(l=>[l[0],l[1],l[2]]));
D.splice(0,D.length,...V.map(r=>({...r,d:new Date(r.ts)})));
if(!D.length){cur=0;kfirst=true;kpis();tahap();tabs();table();ready();logs();
 $('#dcard').innerHTML='<div class="mu" style="padding:30px;text-align:center;line-height:1.7"><b style="color:var(--tx)">Belum ada pendaftar yang siap diseleksi.</b><br>Hanya pendaftaran berstatus <b>Terkirim</b> yang tampil di sini.</div>';return}
cur=D[0].id;dec=D[0].sel;kfirst=true;all();_sc(cur);
})();
</script>
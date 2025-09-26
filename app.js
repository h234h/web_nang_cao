// Elements
const topnav = document.getElementById('topnav');
const bellBtn = document.getElementById('btnBell');
const notify  = document.getElementById('notifyPanel');
const searchForm = document.getElementById('searchForm');
const searchInput = document.getElementById('searchInput');

// Sections map
const sections = {
  overview:  document.getElementById('section-overview'),
  products:  document.getElementById('section-products'),
  categories:document.getElementById('section-categories'),
  orders:    document.getElementById('section-orders'),
  customers: document.getElementById('section-customers'),
  vouchers:  document.getElementById('section-vouchers'),
  revenue:   document.getElementById('section-revenue'),
  comments:  document.getElementById('section-comments'),
};

/* ---------- Router ---------- */
function showSection(key){
  Object.values(sections).forEach(s => s.classList.remove('active'));
  topnav.querySelectorAll('.nav-item').forEach(a => a.classList.remove('active'));
  sections[key]?.classList.add('active');
  topnav.querySelector(`[data-section="${key}"]`)?.classList.add('active');
  if (key === 'revenue') renderRevenue(); // refresh chart khi vào tab Doanh thu
}
function getHash(){
  const h = (location.hash||'').replace('#','').toLowerCase();
  return sections[h] ? h : 'overview';
}
topnav.addEventListener('click', (e)=>{
  const a = e.target.closest('a.nav-item'); if (!a) return;
  e.preventDefault();
  const sec = a.dataset.section;
  if (location.hash !== `#${sec}`) history.pushState(null,'',`#${sec}`);
  showSection(sec);
});
window.addEventListener('load', ()=> showSection(getHash()));
window.addEventListener('hashchange', ()=> showSection(getHash()));

/* ---------- Search ---------- */
searchForm?.addEventListener('submit', (e)=>{
  e.preventDefault();
  const q = (searchInput?.value || '').trim().toLowerCase();
  if (!q) return;
  const item = Array.from(topnav.querySelectorAll('.nav-item'))
    .find(a => (a.textContent || '').toLowerCase().includes(q));
  if (item) item.click();
});

/* ---------- Notifications ---------- */
function toggleNotify(force){
  const open = typeof force==='boolean' ? force : notify.classList.contains('hidden');
  notify.classList.toggle('hidden', !open);
  bellBtn?.setAttribute('aria-expanded', open ? 'true' : 'false');
}
bellBtn?.addEventListener('click', (e)=>{ e.stopPropagation(); toggleNotify(); });
document.addEventListener('click', (e)=>{
  if (notify.classList.contains('hidden')) return;
  if (!bellBtn.contains(e.target) && !notify.contains(e.target)) toggleNotify(false);
});
window.addEventListener('keydown', (e)=>{ if(e.key==='Escape') toggleNotify(false); });

/* ===========================================================
   DOANH THU: tuần / tháng / năm + CHỌN NĂM
   - week & month: 1 bộ dữ liệu
   - year: nhiều năm có thể chọn từ dropdown (tự tạo)
=========================================================== */

// Tabs
const tabs = document.querySelectorAll('.tabs .tab');

// Chart elements
const revChart = document.getElementById('revChart');
const revAxis  = document.getElementById('revAxis');
const revTotal = document.getElementById('revTotal');
const revOrders= document.getElementById('revOrders');

// Dataset
const revenueData = {
  week: {
    labels: ['T2','T3','T4','T5','T6','T7','CN'],
    values: [12, 18, 10, 22, 26, 30, 14], // triệu VND
    orders: [8, 12, 7, 15, 17, 19, 9]
  },
  month: {
    labels: Array.from({length: 30}, (_,i)=> String(i+1)),
    values: [12,14,9,18,10,16,20,22,18,25, 14,12,19,21,15, 28,24,18,20,23, 26,22,18,19,17, 21,25,23,29],
    orders: [9,10,7,12,8,10,13,14,12,16, 10,8,12,13,9, 18,15,11,12,13, 15,12,11,11,10, 12,14,13,16]
  },
  year: {
    // mỗi năm 12 tháng
    '2023': {
      labels: ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
      values: [95,110,105,130,145,170,165,150,180,195,205,220],
      orders: [70,78,74,86,95,108,105,98,112,120,126,134]
    },
    '2024': {
      labels: ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
      values: [120,140,110,160,180,220,210,190,230,260,240,300],
      orders: [80,92,75,100,110,130,128,120,135,150,142,170]
    },
    '2025': {
      labels: ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
      values: [130,150,125,170,190,235,225,210,245,275,260,320],
      orders: [85,98,82,108,118,138,136,128,142,158,150,182]
    }
  }
};

let currentRange = 'week';
let currentYear  = null; // sẽ set khi vào tab "year"

// ---- Tạo Year Picker động bên cạnh tabs (nếu cần) ----
function ensureYearPicker(){
  const tabsWrap = document.querySelector('.tabs');
  if (!tabsWrap) return { wrap: null, select: null };

  let wrap = document.querySelector('.year-picker');
  if (!wrap){
    wrap = document.createElement('div');
    wrap.className = 'year-picker';
    wrap.style.display = 'flex';
    wrap.style.alignItems = 'center';
    wrap.style.gap = '8px';
    wrap.style.marginLeft = 'auto'; // đẩy về cạnh phải hàng controls

    const label = document.createElement('label');
    label.textContent = 'Năm';
    label.style.color = '#334155';
    label.style.fontWeight = '600';
    label.htmlFor = 'yearSelect';

    const select = document.createElement('select');
    select.id = 'yearSelect';
    select.style.height = '36px';
    select.style.border = '1px solid #e6e9ef';
    select.style.borderRadius = '8px';
    select.style.padding = '0 10px';
    select.style.background = '#fff';
    select.style.fontWeight = '600';

    wrap.appendChild(label);
    wrap.appendChild(select);

    // chèn wrap ngay sau .tabs trong cùng container
    const controls = tabsWrap.parentElement;
    controls?.appendChild(wrap);
  }

  const select = wrap.querySelector('select');
  // fill options theo dataset
  const years = Object.keys(revenueData.year).sort();
  if (select.options.length !== years.length){
    select.innerHTML = years.map(y => `<option value="${y}">${y}</option>`).join('');
  }
  // năm mặc định: lớn nhất
  currentYear = currentYear || years[years.length - 1];
  select.value = currentYear;
  // lắng nghe thay đổi
  select.onchange = () => { currentYear = select.value; renderRevenue(); };

  return { wrap, select };
}

// Tabs range
tabs.forEach(btn=>{
  btn.addEventListener('click', ()=>{
    tabs.forEach(b=>{ b.classList.remove('active'); b.setAttribute('aria-selected','false'); });
    btn.classList.add('active'); btn.setAttribute('aria-selected','true');
    currentRange = btn.dataset.range;

    // Hiện/ẩn year picker theo range
    const { wrap } = ensureYearPicker();
    if (wrap){
      wrap.style.display = (currentRange === 'year') ? 'flex' : 'none';
    }
    renderRevenue();
  });
});

function formatVND(million){ return `${million}M`; }

function renderRevenue(){
  // bảo đảm year picker tồn tại nếu cần
  const { wrap } = ensureYearPicker();
  if (wrap){
    wrap.style.display = (currentRange === 'year') ? 'flex' : 'none';
  }

  let data;
  if (currentRange === 'year'){
    const years = Object.keys(revenueData.year).sort();
    const y = currentYear || years[years.length - 1];
    currentYear = y;
    data = revenueData.year[y];
    // sync select nếu có
    const select = document.getElementById('yearSelect');
    if (select && select.value !== y) select.value = y;
  } else {
    data = revenueData[currentRange];
  }
  if (!data) return;

  // Tổng
  const total = data.values.reduce((a,b)=>a+b,0);
  const orderTotal = data.orders.reduce((a,b)=>a+b,0);
  revTotal.textContent  = formatVND(total);
  revOrders.textContent = orderTotal.toString();

  // Vẽ chart
  revChart.innerHTML = '';
  revAxis.innerHTML  = '';
  const max = Math.max(...data.values) || 1;

  data.values.forEach((v, i)=>{
    const bar = document.createElement('div');
    bar.className = 'bar';
    bar.dataset.value = formatVND(v);
    const fill = document.createElement('div');
    fill.className = 'fill';
    fill.style.height = `${(v / max) * 100}%`;
    bar.appendChild(fill);
    revChart.appendChild(bar);

    const ax = document.createElement('div');
    ax.className = 'axis-label';
    ax.textContent = data.labels[i] || '';
    revAxis.appendChild(ax);
  });
}

// Vẽ lần đầu nếu đang ở trang Doanh thu
if (location.hash.replace('#','') === 'revenue') {
  renderRevenue();
}

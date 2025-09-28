(function () {
  const box = document.getElementById('catFormBox');
  if (!box) return;

  let existRaw = box.dataset.existing || "[]";
  let currentRaw = box.dataset.current || "";

  const norm = (s) => (s || "").normalize("NFC").toLowerCase().trim();

  let EXISTING = [];
  try { EXISTING = JSON.parse(existRaw).map(norm); } catch (_) { EXISTING = []; }
  const CURRENT = norm(currentRaw);

  const input = document.getElementById('cat-name');
  const form  = input?.closest('form');
  const errEl = document.getElementById('nameErr');

  if (!input || !form || !errEl) return;

  const isDup = (val) => {
    const v = norm(val);
    if (!v) return false;
    if (CURRENT && v === CURRENT) return false; // đang sửa, giữ tên cũ
    return EXISTING.includes(v);
  };

  const showError = (show, text) => {
    if (show) {
      errEl.textContent = text;
      errEl.classList.remove('hidden');
      input.setAttribute('aria-invalid', 'true');
    } else {
      errEl.classList.add('hidden');
      input.removeAttribute('aria-invalid');
    }
  };

  // **Chỉ check khi submit**
  form.addEventListener('submit', (e) => {
    if (isDup(input.value)) {
      e.preventDefault();
      showError(true, 'Tên danh mục đã tồn tại.');
      const t = document.createElement('div');
      t.className = 'toast warning';
      t.textContent = 'Danh mục đã tồn tại: ' + input.value.trim();
      document.body.appendChild(t);
      setTimeout(() => t.classList.add('hide'), 2500);
      setTimeout(() => t.remove(), 2800);
      input.focus();
    } else {
      showError(false);
    }
  });
})();

/*Kiểm tra trùng tên sản phẩm */
(function () {
  const box = document.getElementById('prodFormBox');
  if (!box) return;

  let existRaw = box.dataset.existing || "[]";
  let currentRaw = box.dataset.current || "";

  const norm = (s) => (s || "").normalize("NFC").toLowerCase().trim();

  let EXISTING = [];
  try { EXISTING = JSON.parse(existRaw).map(norm); } catch (_) { EXISTING = []; }
  const CURRENT = norm(currentRaw);

  const input = document.getElementById('prod-name');
  const form  = input?.closest('form');
  const errEl = document.getElementById('prodNameErr');

  if (!input || !form || !errEl) return;

  const isDup = (val) => {
    const v = norm(val);
    if (!v) return false;
    if (CURRENT && v === CURRENT) return false; // đang sửa, giữ nguyên tên cũ
    return EXISTING.includes(v);
  };

  const showError = (show, text) => {
    if (show) {
      errEl.textContent = text;
      errEl.classList.remove('hidden');
      input.setAttribute('aria-invalid', 'true');
    } else {
      errEl.classList.add('hidden');
      input.removeAttribute('aria-invalid');
    }
  };

  // ✅ Chỉ check khi submit
  form.addEventListener('submit', (e) => {
    if (isDup(input.value)) {
      e.preventDefault();
      showError(true, 'Tên sản phẩm đã tồn tại.');
      const t = document.createElement('div');
      t.className = 'toast warning';
      t.textContent = 'Sản phẩm đã tồn tại: ' + input.value.trim();
      document.body.appendChild(t);
      setTimeout(() => t.classList.add('hide'), 2500);
      setTimeout(() => t.remove(), 2800);
      input.focus();
    } else {
      showError(false);
    }
  });
})();

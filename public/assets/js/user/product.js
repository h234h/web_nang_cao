// JS cho trang chi tiết sản phẩm
document.addEventListener("DOMContentLoaded", () => {
  const box = document.querySelector(".qty-box");
  if (!box) return;

  const minusBtn = box.querySelector(".qty-minus");
  const plusBtn  = box.querySelector(".qty-plus");
  const input    = box.querySelector(".qty-input");
  const hidden   = document.getElementById("hiddenQty");

  const min = Math.max(1, parseInt(box.getAttribute("data-min") || "1", 10));
  const max = Math.max(min, parseInt(box.getAttribute("data-max") || "99", 10));

  // Clamp tiện dụng
  const clamp = (n) => Math.min(max, Math.max(min, n));

  // Cập nhật nút enable/disable + đồng bộ hidden
  const refreshUI = () => {
    const val = parseInt(input.value || `${min}`, 10);
    minusBtn.disabled = val <= min;
    plusBtn.disabled  = val >= max;

    if (hidden) hidden.value = val; // đồng bộ input ẩn trong form submit
  };

  // Khởi tạo
  input.value = clamp(parseInt(input.value || `${min}`, 10));
  refreshUI();

  // Click “–”
  minusBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    const val = clamp(parseInt(input.value || `${min}`, 10) - 1);
    input.value = val;
    refreshUI();
  });

  // Click “+”
  plusBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    const val = clamp(parseInt(input.value || `${min}`, 10) + 1);
    input.value = val;
    refreshUI();
  });

  // Nhập tay
  input.addEventListener("input", () => {
    const raw = input.value.replace(/[^\d]/g, "");
    input.value = raw === "" ? "" : raw; // cho phép xóa tạm thời
  });

  input.addEventListener("blur", () => {
    // khi rời input, chốt về khoảng cho phép
    const val = clamp(parseInt(input.value || `${min}`, 10));
    input.value = val;
    refreshUI();
  });

  // Chặn phím âm / ký tự lạ
  input.addEventListener("keydown", (e) => {
    const allowed = [
      "Backspace","Delete","ArrowLeft","ArrowRight","Home","End","Tab"
    ];
    if (allowed.includes(e.key)) return;
    if (e.key === "Enter") return; // để form submit bình thường
    if (!/^\d$/.test(e.key)) e.preventDefault();
  });
});

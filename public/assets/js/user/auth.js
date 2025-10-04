/* public/assets/js/auth-lite.js
 * OOP: chỉ xử lý UI (mắt mật khẩu + flash tự ẩn)
 */
class AuthUI {
  constructor(options = {}) {
    this.eyeSelector   = options.eyeSelector ?? '[data-eye]';
    this.flashSelector = options.flashSelector ?? '.flash';
    this.defaultHideMs = options.defaultHideMs ?? 2400;

    // cache DOM lazily
    this._eyes = null;
    this._flashes = null;
  }

  // Entry
  init() {
    this._cache();
    this._bindEyeToggles();
    this._autoHideFlashes();
  }

  /* ---------------- private helpers ---------------- */
  _cache() {
    this._eyes = Array.from(document.querySelectorAll(this.eyeSelector));
    this._flashes = Array.from(document.querySelectorAll(this.flashSelector));
  }

  _bindEyeToggles() {
    this._eyes.forEach((btn) => {
      const targetSel = btn.getAttribute('data-eye');
      const input = document.querySelector(targetSel);
      if (!input) return;

      btn.addEventListener('click', () => {
        const isPwd = input.type === 'password';
        input.type = isPwd ? 'text' : 'password';

        const icon = btn.querySelector('i');
        if (icon) icon.className = isPwd ? 'bi bi-eye-slash' : 'bi bi-eye';

        // giữ focus trên input cho UX mượt
        input.focus();
      });
    });
  }

  _autoHideFlashes() {
    this._flashes.forEach((el) => {
      const msAttr = el.getAttribute('data-autohide');
      const ms = Number.parseInt(msAttr || this.defaultHideMs, 10);

      // cho CSS biết thời gian để animate nếu cần
      el.style.setProperty('--hide', `${ms}ms`);

      window.setTimeout(() => {
        // fade-out nhẹ nhàng nếu muốn (an toàn khi không có CSS)
        el.style.transition = 'opacity .2s ease, transform .2s ease';
        el.style.opacity = '0';
        el.style.transform = 'translateY(-4px)';
        window.setTimeout(() => el.remove(), 220);
      }, ms);
    });
  }
}

/* Bootstrap */
document.addEventListener('DOMContentLoaded', () => {
  new AuthUI({
    eyeSelector: '[data-eye]',
    flashSelector: '.flash',
    defaultHideMs: 2400
  }).init();
});

// public/assets/js/user/header.js
class HeaderUI {
  constructor() {
    // Drawer (mobile)
    this.burger   = document.querySelector('.menu-toggle');
    this.drawer   = document.querySelector('.drawer');
    this.backdrop = document.querySelector('.drawer-backdrop');
    this.btnClose = document.querySelector('.drawer__close');

    // Dropdown (Categories hoặc dropdown khác dùng .nav-dropdown__btn)
    this.dropBtns = document.querySelectorAll('.nav-dropdown__btn');

    // User menu (avatar)
    this.userBtn  = document.querySelector('.user .user__btn');
    this.userMenu = document.querySelector('.user-menu');

    // Option: search icon (chưa xử lý logic search theo yêu cầu)
    this.openSearchBtn = document.querySelector('.js-open-search');

    // Bind all events
    this.bind();
  }

  bind() {
    // Drawer
    this.burger?.addEventListener('click', () => this.openDrawer());
    this.btnClose?.addEventListener('click', () => this.closeDrawer());
    this.backdrop?.addEventListener('click', () => this.closeDrawer());

    // ESC to close things
    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.closeDrawer();
        this.closeUserMenu();
        this.closeAllDropdowns();
      }
    });

    // Dropdown click (giữ hover bằng CSS, click để hỗ trợ mobile/desktop)
    this.dropBtns.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const wrap = btn.closest('.nav-dropdown');
        if (!wrap) return;

        // Đóng các dropdown khác
        this.closeAllDropdowns(wrap);

        wrap.classList.toggle('is-open');
        const menu = wrap.querySelector('.nav-dropdown__menu');
        if (menu) {
          const open = wrap.classList.contains('is-open');
          menu.style.display = open ? 'block' : '';
        }
      });
    });

    // User menu
    if (this.userBtn && this.userMenu) {
      this.userBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        this.userMenu.classList.toggle('show');
      });

      // Click outside để đóng cả dropdown & user menu
      document.addEventListener('click', (e) => {
        // Close user menu if clicking outside
        if (!this.userMenu.contains(e.target) && !this.userBtn.contains(e.target)) {
          this.closeUserMenu();
        }
        // Close all dropdowns if clicking outside any dropdown container
        const clickedInsideDropdown = e.target.closest('.nav-dropdown');
        if (!clickedInsideDropdown) this.closeAllDropdowns();
      });
    }
  }

  /* ---------- Drawer ---------- */
  openDrawer() {
    this.drawer?.classList.add('show');
    this.backdrop?.classList.add('show');
    document.body.style.overflow = 'hidden';
  }
  closeDrawer() {
    this.drawer?.classList.remove('show');
    this.backdrop?.classList.remove('show');
    document.body.style.overflow = '';
  }

  /* ---------- Dropdown helpers ---------- */
  closeAllDropdowns(exceptWrap = null) {
    document.querySelectorAll('.nav-dropdown.is-open').forEach((wrap) => {
      if (exceptWrap && wrap === exceptWrap) return;
      wrap.classList.remove('is-open');
      const menu = wrap.querySelector('.nav-dropdown__menu');
      if (menu) menu.style.display = '';
    });
  }

  /* ---------- User menu ---------- */
  closeUserMenu() {
    this.userMenu?.classList.remove('show');
  }
}

document.addEventListener('DOMContentLoaded', () => new HeaderUI());

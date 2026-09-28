/* ===========================================================================
 * resources/js/app.js
 * ---------------------------------------------------------------------------
 * Entry point JavaScript (vanilla, tanpa framework/CDN) yang dipanggil dari
 * Blade melalui directive @vite.
 *
 * Berisi tiga peningkatan progresif (progressive enhancement):
 *   1. Toggle menu navigasi responsif (mobile).
 *   2. Tombol tutup pada <x-status-banner> (auto-dismiss opsional).
 *   3. Penghitung karakter + konfirmasi kirim pada formulir ide riset.
 *
 * Karena semua skrip dimuat sebagai modul ES (`type="module"` dari Vite),
 * pemanggilan init ditunda sampai DOM siap.
 * =========================================================================== */

/**
 * Inisialisasi toggle navbar mobile.
 * Tombol memakai aria-expanded + atribut `hidden` pada panel menu.
 */
function initMobileNav() {
    const toggle = document.querySelector('[data-nav-toggle]');
    const menu = document.querySelector('[data-nav-menu]');

    if (!toggle || !menu) {
        return;
    }

    const setOpen = (open) => {
        toggle.setAttribute('aria-expanded', String(open));
        menu.classList.toggle('hidden', !open);
    };

    toggle.addEventListener('click', () => {
        setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    // Tutup menu saat salah satu tautan diklik (UX mobile).
    menu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });
}

/**
 * Inisialisasi tombol tutup pada komponen <x-status-banner>.
 * Banner dengan atribut `data-autodismiss` akan hilang otomatis.
 */
function initStatusBanners() {
    document.querySelectorAll('[data-banner]').forEach((banner) => {
        const closeButton = banner.querySelector('[data-banner-close]');

        const dismiss = () => {
            banner.style.transition = 'opacity 200ms ease, transform 200ms ease';
            banner.style.opacity = '0';
            banner.style.transform = 'translateY(-6px)';
            window.setTimeout(() => banner.remove(), 220);
        };

        closeButton?.addEventListener('click', dismiss);

        const delay = Number(banner.dataset.autodismiss ?? 0);
        if (delay > 0) {
            window.setTimeout(dismiss, delay);
        }
    });
}

/**
 * Inisialisasi penghitung karakter textarea pada formulir ide.
 */
function initCharacterCounter() {
    document.querySelectorAll('[data-counter-for]').forEach((counter) => {
        const target = document.getElementById(counter.dataset.counterFor);

        if (!target) {
            return;
        }

        const max = Number(counter.dataset.counterMax ?? target.getAttribute('maxlength') ?? 0);
        const render = () => {
            counter.textContent = max > 0
                ? `${target.value.length}/${max} karakter`
                : `${target.value.length} karakter`;
        };

        target.addEventListener('input', render);
        render();
    });
}

/**
 * Konfirmasi sebelum formulir ide dikirim (mencegah submit tidak sengaja).
 */
function initConfirmForms() {
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });
}

/** Bootstrapping seluruh modul setelah DOM siap. */
function boot() {
    initMobileNav();
    initStatusBanners();
    initCharacterCounter();
    initConfirmForms();

    // Penanda versi di console untuk memudahkan verifikasi saat demo.
    console.info(
        '%c PBKK Tugas 4 %c Blade + Vite + Tailwind aktif ',
        'background:#1c4ff5;color:#fff;border-radius:4px 0 0 4px;padding:2px 6px',
        'background:#0f172a;color:#7dd3fc;border-radius:0 4px 4px 0;padding:2px 6px',
    );
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}

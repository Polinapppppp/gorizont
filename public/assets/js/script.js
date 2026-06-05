document.addEventListener('DOMContentLoaded', function () {

    function smoothScrollTo(target, offset) {
        offset = offset || 80;
        const element = typeof target === 'string' ? document.querySelector(target) : target;
        if (!element) return;

        const elementPosition = element.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - offset;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#' || !href) return;

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                smoothScrollTo(target);
            }
        });
    });

    window.smoothScrollToElement = smoothScrollTo;
});


document.addEventListener('DOMContentLoaded', function () {
    const burgerBtn = document.getElementById('burgerBtn');
    const mobileMenu = document.getElementById('mobileMenuOverlay');
    const body = document.body;

    if (!burgerBtn || !mobileMenu) return;

    const closeCross = document.createElement('div');
    closeCross.id = 'mobileCloseCross';
    closeCross.innerHTML = '✕';
    closeCross.style.cssText = `
        position: fixed !important;
        top: 20px !important;
        right: 20px !important;
        width: 44px !important;
        height: 44px !important;
        background: white !important;
        color: #152532 !important;
        font-size: 32px !important;
        font-weight: bold !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 50% !important;
        cursor: pointer !important;
        z-index: 999999 !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3) !important;
        font-family: Arial, sans-serif !important;
        transition: all 0.2s !important;
    `;

    closeCross.onmouseenter = () => closeCross.style.background = '#f0f0f0';
    closeCross.onmouseleave = () => closeCross.style.background = 'white';

    mobileMenu.appendChild(closeCross);

    function closeMenu() {
        mobileMenu.classList.remove('is-open');
        burgerBtn.classList.remove('active');
        body.style.overflow = '';
    }

    closeCross.addEventListener('click', function (e) {
        e.stopPropagation();
        closeMenu();
    });

    mobileMenu.addEventListener('click', function (e) {
        if (e.target === mobileMenu) {
            closeMenu();
        }
    });

    burgerBtn.addEventListener('click', function () {
        this.classList.toggle('active');
        mobileMenu.classList.toggle('is-open');

        if (mobileMenu.classList.contains('is-open')) {
            body.style.overflow = 'hidden';
        } else {
            body.style.overflow = '';
        }
    });

    mobileMenu.querySelectorAll('a, button').forEach(item => {
        item.addEventListener('click', function () {
            closeMenu();
        });
    });
});

import.meta.glob(['../images/**']);

document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal-on-scroll').forEach((el) => observer.observe(el));

    const nav = document.getElementById('navbar');
    if (nav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('shadow-sm');
            } else {
                nav.classList.remove('shadow-sm');
            }
        });
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.target);
                let current = 0;
                const increment = Math.ceil(target / 60);
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        el.textContent = target;
                        clearInterval(timer);
                    } else {
                        el.textContent = current;
                    }
                }, 25);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.counter').forEach((el) => counterObserver.observe(el));

    window.toggleMenu = function () {
        var menu = document.getElementById('mobile-menu');
        var toggle = document.getElementById('menu-toggle');
        if (menu) {
            menu.classList.toggle('hidden');
            var isOpen = !menu.classList.contains('hidden');
            if (toggle) {
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }
        }
    };

    window.addEventListener('pageshow', function () {
        var menu = document.getElementById('mobile-menu');
        if (menu && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
        }
    });

    // Checksum anti-spam: cualquier formulario con input js_checksum se marca como "cargado por JS"
    document.querySelectorAll('input[name="js_checksum"]').forEach(function (el) {
        el.value = '2';
    });

    // ===== Formulario de evaluación preliminar (home) =====

    // Selección de etapa (stage cards)
    window.selectStageCard = function (card, stageKey) {
        document.querySelectorAll('.stage-card').forEach(function (el) {
            el.classList.remove('active');
            el.setAttribute('aria-pressed', 'false');
        });
        card.classList.add('active');
        card.setAttribute('aria-pressed', 'true');

        var etapaInput = document.getElementById('etapa-value');
        if (etapaInput) {
            etapaInput.value = stageKey;
        }
    };

    // Chips de requerimientos (multi-selección)
    window.toggleNeedChip = function (chip) {
        chip.classList.toggle('active');
        var input = document.getElementById('requerimientos-value');
        if (!input) return;

        var active = Array.from(document.querySelectorAll('.chip.active')).map(function (el) {
            return el.textContent.trim();
        });
        input.value = active.join(', ');
    };
});

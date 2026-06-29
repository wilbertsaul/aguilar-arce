import.meta.glob(['../images/**']);

// Scroll reveal
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = { threshold: 0.1 };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal-on-scroll').forEach((el) => observer.observe(el));

    // Navbar shrink on scroll
    const nav = document.getElementById('navbar');
    if (nav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('h-16');
                nav.classList.remove('h-20');
            } else {
                nav.classList.add('h-20');
                nav.classList.remove('h-16');
            }
        });
    }
});

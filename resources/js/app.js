import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    NavbarController.init();
    TypingEffect.init();
    ParticlesCanvas.init();
    ScrollReveal.init();
    CounterAnimation.init();
    ProjectFilter.init();
    ContactForm.init();
    SmoothScrollLinks.init();
});

/* ─── 1. NavbarController ───────────────────────────────── */
const NavbarController = {
    nav: null,
    hamburger: null,
    mobileMenu: null,

    init() {
        this.nav = document.getElementById('main-nav');
        this.hamburger = document.getElementById('hamburger-btn');
        this.mobileMenu = document.getElementById('mobile-menu');

        if (!this.nav) return;

        window.addEventListener('scroll', () => this.onScroll(), { passive: true });
        this.onScroll();

        if (this.hamburger && this.mobileMenu) {
            this.hamburger.addEventListener('click', () => this.toggleMobile());
        }

        this.initActiveLinks();
    },

    onScroll() {
        if (window.scrollY > 60) {
            this.nav.classList.add('nav-scrolled');
        } else {
            this.nav.classList.remove('nav-scrolled');
        }
    },

    toggleMobile() {
        const isOpen = this.mobileMenu.classList.contains('open');
        if (isOpen) {
            this.mobileMenu.style.maxHeight = '0';
            this.mobileMenu.classList.remove('open');
            this.hamburger.setAttribute('aria-expanded', 'false');
        } else {
            this.mobileMenu.style.maxHeight = this.mobileMenu.scrollHeight + 'px';
            this.mobileMenu.classList.add('open');
            this.hamburger.setAttribute('aria-expanded', 'true');
        }
        // Animate hamburger lines
        const lines = this.hamburger.querySelectorAll('.hamburger-line');
        lines[0].classList.toggle('rotate-45');
        lines[0].classList.toggle('translate-y-1.5');
        lines[1].classList.toggle('opacity-0');
        lines[2].classList.toggle('-rotate-45');
        lines[2].classList.toggle('-translate-y-1.5');
    },

    initActiveLinks() {
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        if (!sections.length || !navLinks.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(link => {
                        link.classList.remove('text-accent-primary', 'text-glow');
                        link.classList.add('text-slate-300');
                        if (link.getAttribute('href') === '#' + entry.target.id) {
                            link.classList.add('text-accent-primary', 'text-glow');
                            link.classList.remove('text-slate-300');
                        }
                    });
                }
            });
        }, { threshold: 0.4 });

        sections.forEach(s => observer.observe(s));
    }
};

/* ─── 2. TypingEffect ───────────────────────────────────── */
const TypingEffect = {
    phrases: [
        'Développeur Full-Stack',
        'Créateur d\'interfaces',
        'Architecte Laravel',
        'Designer UI/UX',
        'Passionné de code',
    ],
    el: null,
    index: 0,
    charIndex: 0,
    isDeleting: false,
    speed: { type: 80, delete: 45, pause: 1800 },

    init() {
        this.el = document.getElementById('typing-text');
        if (!this.el) return;
        this.tick();
    },

    tick() {
        const current = this.phrases[this.index];
        const displayed = this.isDeleting
            ? current.substring(0, this.charIndex - 1)
            : current.substring(0, this.charIndex + 1);

        this.el.textContent = displayed;
        this.charIndex = this.isDeleting ? this.charIndex - 1 : this.charIndex + 1;

        let delay = this.isDeleting ? this.speed.delete : this.speed.type;

        if (!this.isDeleting && displayed === current) {
            delay = this.speed.pause;
            this.isDeleting = true;
        } else if (this.isDeleting && displayed === '') {
            this.isDeleting = false;
            this.index = (this.index + 1) % this.phrases.length;
            delay = 300;
        }

        setTimeout(() => this.tick(), delay);
    }
};

/* ─── 3. ParticlesCanvas ────────────────────────────────── */
const ParticlesCanvas = {
    canvas: null,
    ctx: null,
    particles: [],
    mouse: { x: -9999, y: -9999 },
    COUNT: 55,

    init() {
        this.canvas = document.getElementById('hero-canvas');
        if (!this.canvas) return;

        this.ctx = this.canvas.getContext('2d');
        this.resize();
        this.buildParticles();
        this.bindEvents();
        this.loop();
    },

    resize() {
        this.canvas.width  = this.canvas.offsetWidth;
        this.canvas.height = this.canvas.offsetHeight;
    },

    buildParticles() {
        this.particles = [];
        for (let i = 0; i < this.COUNT; i++) {
            this.particles.push({
                x:   Math.random() * this.canvas.width,
                y:   Math.random() * this.canvas.height,
                vx:  (Math.random() - 0.5) * 0.5,
                vy:  (Math.random() - 0.5) * 0.5,
                r:   Math.random() * 1.8 + 0.5,
                alpha: Math.random() * 0.5 + 0.2,
                cyan: Math.random() > 0.5,
            });
        }
    },

    bindEvents() {
        window.addEventListener('resize', () => { this.resize(); this.buildParticles(); }, { passive: true });
        this.canvas.closest('section')?.addEventListener('mousemove', (e) => {
            const rect = this.canvas.getBoundingClientRect();
            this.mouse.x = e.clientX - rect.left;
            this.mouse.y = e.clientY - rect.top;
        });
        this.canvas.closest('section')?.addEventListener('mouseleave', () => {
            this.mouse.x = -9999;
            this.mouse.y = -9999;
        });
    },

    loop() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        this.particles.forEach(p => {
            // Mouse repulsion
            const dx = p.x - this.mouse.x;
            const dy = p.y - this.mouse.y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < 100) {
                p.x += (dx / dist) * 1.5;
                p.y += (dy / dist) * 1.5;
            }

            p.x += p.vx;
            p.y += p.vy;

            // Wrap edges
            if (p.x < 0) p.x = this.canvas.width;
            if (p.x > this.canvas.width) p.x = 0;
            if (p.y < 0) p.y = this.canvas.height;
            if (p.y > this.canvas.height) p.y = 0;

            // Draw particle
            this.ctx.beginPath();
            this.ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            this.ctx.fillStyle = p.cyan
                ? `rgba(0, 242, 255, ${p.alpha})`
                : `rgba(188, 19, 254, ${p.alpha})`;
            this.ctx.fill();
        });

        // Draw connecting lines
        for (let i = 0; i < this.particles.length; i++) {
            for (let j = i + 1; j < this.particles.length; j++) {
                const a = this.particles[i];
                const b = this.particles[j];
                const dx = a.x - b.x;
                const dy = a.y - b.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 140) {
                    const alpha = (1 - dist / 140) * 0.15;
                    this.ctx.beginPath();
                    this.ctx.moveTo(a.x, a.y);
                    this.ctx.lineTo(b.x, b.y);
                    this.ctx.strokeStyle = `rgba(0, 242, 255, ${alpha})`;
                    this.ctx.lineWidth = 0.5;
                    this.ctx.stroke();
                }
            }
        }

        requestAnimationFrame(() => this.loop());
    }
};

/* ─── 4. ScrollReveal ───────────────────────────────────── */
const ScrollReveal = {
    init() {
        const targets = document.querySelectorAll('.section-reveal, .reveal-left, .reveal-right');
        if (!targets.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const delay = el.dataset.delay || 0;
                    setTimeout(() => el.classList.add('revealed'), Number(delay));
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -50px 0px' });

        targets.forEach(el => observer.observe(el));
    }
};

/* ─── 5. CounterAnimation ───────────────────────────────── */
const CounterAnimation = {
    init() {
        const counters = document.querySelectorAll('.counter-value');
        if (!counters.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animate(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(el => observer.observe(el));
    },

    animate(el) {
        const target = parseInt(el.dataset.target, 10);
        const suffix = el.dataset.suffix || '';
        const duration = 1500;
        const start = performance.now();

        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(eased * target);
            el.textContent = current >= 1000 ? (current / 1000).toFixed(1) + 'K' + suffix : current + suffix;
            if (progress < 1) requestAnimationFrame(step);
        };

        requestAnimationFrame(step);
    }
};

/* ─── 6. ProjectFilter ──────────────────────────────────── */
const ProjectFilter = {
    init() {
        const buttons = document.querySelectorAll('[data-filter]');
        const cards   = document.querySelectorAll('[data-category]');
        if (!buttons.length || !cards.length) return;

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.filter;

                buttons.forEach(b => {
                    b.classList.remove('border-accent-primary', 'text-accent-primary', 'bg-accent-primary/10');
                    b.classList.add('border-white/10', 'text-slate-400');
                });
                btn.classList.remove('border-white/10', 'text-slate-400');
                btn.classList.add('border-accent-primary', 'text-accent-primary', 'bg-accent-primary/10');

                cards.forEach(card => {
                    const match = filter === 'all' || card.dataset.category === filter;
                    if (match) {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95)';
                        card.style.display = '';
                        requestAnimationFrame(() => {
                            card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        });
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => { card.style.display = 'none'; }, 400);
                    }
                });
            });
        });
    }
};

/* ─── 7. ContactForm ────────────────────────────────────── */
const ContactForm = {
    init() {
        const form = document.getElementById('contact-form');
        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = form.querySelector('[type="submit"]');
            const original = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="animate-pulse">Envoi en cours...</span>';

            try {
                const data = new FormData(form);
                const res = await fetch('/contact', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json',
                    },
                    body: data,
                });

                const json = await res.json();

                if (res.ok && json.success) {
                    ToastNotification.show('Message envoyé ! Je vous répondrai rapidement.', 'success');
                    form.reset();
                } else if (res.status === 422 && json.errors) {
                    const firstError = Object.values(json.errors)[0][0];
                    ToastNotification.show(firstError, 'error');
                } else if (res.status === 429) {
                    ToastNotification.show('Trop de tentatives. Réessayez dans une minute.', 'error');
                } else {
                    ToastNotification.show('Une erreur est survenue. Réessayez.', 'error');
                }
            } catch {
                ToastNotification.show('Erreur réseau. Vérifiez votre connexion.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = original;
            }
        });
    }
};

/* ─── 8. ToastNotification ──────────────────────────────── */
const ToastNotification = {
    show(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <span>${type === 'success' ? '✓' : '✕'}</span>
                <span>${message}</span>
            </div>`;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('toast-exit');
            setTimeout(() => toast.remove(), 350);
        }, 4000);
    }
};

/* ─── 9. SmoothScrollLinks ──────────────────────────────── */
const SmoothScrollLinks = {
    init() {
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                const target = document.querySelector(link.getAttribute('href'));
                if (!target) return;
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });

                // Close mobile menu if open
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu?.classList.contains('open')) {
                    NavbarController.toggleMobile();
                }
            });
        });
    }
};

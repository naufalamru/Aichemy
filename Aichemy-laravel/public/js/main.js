// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', function() {
    initParticles();
    initNavbar();
    initScrollAnimations();
    initCounters();
    initTeamSlider();
    initBackToTop();
    initSmoothScroll();
});

// ==================== PARTICLES BACKGROUND ====================
function initParticles() {
    const particlesContainer = document.getElementById('particles');
    const particleCount = 50;

    for (let i = 0; i < particleCount; i++) {
        createParticle(particlesContainer);
    }
}

function createParticle(container) {
    const particle = document.createElement('div');
    const size = Math.random() * 5 + 2;
    const duration = Math.random() * 20 + 10;
    const delay = Math.random() * 5;

    particle.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        background: radial-gradient(circle, rgba(3, 30, 94, 0.8), rgba(95, 179, 248, 0.4));
        border-radius: 50%;
        left: ${Math.random() * 100}%;
        top: ${Math.random() * 100}%;
        animation: float ${duration}s ease-in-out infinite;
        animation-delay: ${delay}s;
        pointer-events: none;
    `;

    container.appendChild(particle);
}

// ==================== NAVBAR ====================
function initNavbar() {
    const navbar = document.getElementById('navbar');
    const mobileToggle = document.getElementById('mobileToggle');
    const navLinks = document.getElementById('navLinks');

    // Scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Mobile menu toggle
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            this.classList.toggle('active');

            // Animate toggle button
            const spans = this.querySelectorAll('span');
            if (this.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    }

    // Close mobile menu when clicking a link
    const navLinksItems = document.querySelectorAll('.nav-link');
    navLinksItems.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.classList.remove('active');
            if (mobileToggle) {
                mobileToggle.classList.remove('active');
                const spans = mobileToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    });
}

// ==================== SCROLL ANIMATIONS ====================
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';

                // Trigger step progress animation
                if (entry.target.classList.contains('step')) {
                    const progress = entry.target.querySelector('.step-progress');
                    if (progress) {
                        setTimeout(() => {
                            progress.style.width = '100%';
                        }, 300);
                    }
                }

                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.step, .stat-card, .why-card, .team-card, .about-box');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
}

// ==================== COUNTER ANIMATION ====================
function initCounters() {
    const counters = document.querySelectorAll('.stat-value');
    const speed = 2000; // Animation duration in ms

    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-count'));
                const increment = target / (speed / 16); // 60 FPS
                let current = 0;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.ceil(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCounter();
                observer.unobserve(counter);
            }
        });
    }, observerOptions);

    counters.forEach(counter => {
        counter.textContent = '0';
        observer.observe(counter);
    });
}

// ==================== TEAM SLIDER ====================
function initTeamSlider() {
    const wrapper = document.getElementById('teamWrapper');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    if (!wrapper) return;

    let scrollAmount = 0;
    let autoScrollInterval;
    const scrollSpeed = 1;
    const scrollDelay = 30;

    // Auto scroll function
    function autoScroll() {
        scrollAmount += scrollSpeed;

        if (scrollAmount >= wrapper.scrollWidth - wrapper.clientWidth) {
            scrollAmount = 0;
        }

        wrapper.scrollTo({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }

    // Start auto scroll
    function startAutoScroll() {
        autoScrollInterval = setInterval(autoScroll, scrollDelay);
    }

    // Stop auto scroll
    function stopAutoScroll() {
        clearInterval(autoScrollInterval);
    }

    // Manual navigation
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            scrollAmount = Math.max(0, scrollAmount - 300);
            wrapper.scrollTo({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            scrollAmount = Math.min(wrapper.scrollWidth - wrapper.clientWidth, scrollAmount + 300);
            wrapper.scrollTo({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    }

    // Pause on hover
    wrapper.addEventListener('mouseenter', stopAutoScroll);
    wrapper.addEventListener('mouseleave', startAutoScroll);

    // Start auto scroll
    startAutoScroll();

    // Update scroll amount on manual scroll
    wrapper.addEventListener('scroll', function() {
        scrollAmount = wrapper.scrollLeft;
    });
}

// ==================== BACK TO TOP BUTTON ====================
function initBackToTop() {
    const backToTop = document.getElementById('backToTop');

    if (!backToTop) return;

    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });

    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// ==================== SMOOTH SCROLL ====================
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));

            if (target) {
                const offsetTop = target.offsetTop - 80; // Offset for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ==================== FLOATING CARDS ANIMATION ====================
const floatingCards = document.querySelectorAll('.floating-card');
floatingCards.forEach((card, index) => {
    card.style.animationDelay = `${index * 0.5}s`;
});

// ==================== PARALLAX EFFECT ====================
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.hero-right, .how-illustration');

    parallaxElements.forEach(element => {
        const speed = 0.3;

        // BATAS maksimum pergerakan
        const maxMove = 80; // px

        // Hitung pergerakan namun tidak boleh lewat maxMove
        const moveY = Math.min(scrolled * speed, maxMove);

        element.style.transform = `translateY(${moveY}px)`;
    });
});


// ==================== CURSOR TRAIL EFFECT (Optional) ====================
let cursorTrail = [];
const trailLength = 10;

document.addEventListener('mousemove', function(e) {
    if (window.innerWidth > 768) { // Only on desktop
        cursorTrail.push({
            x: e.clientX,
            y: e.clientY,
            timestamp: Date.now()
        });

        if (cursorTrail.length > trailLength) {
            cursorTrail.shift();
        }
    }
});

// ==================== TYPING EFFECT FOR HERO TITLE (Optional) ====================
function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.innerHTML = '';

    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }

    type();
}

// ==================== INTERSECTION OBSERVER FOR HERO ====================
const heroObserver = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1 });

const heroElements = document.querySelectorAll('.hero-left > *');
heroElements.forEach((el, index) => {
    el.style.animationDelay = `${index * 0.2}s`;
    heroObserver.observe(el);
});

// ==================== CONSOLE MESSAGE ====================
console.log('%c🧪 Alchemy - AI-Powered Skincare 🧪', 'font-size: 20px; font-weight: bold; color: #8B5CF6;');
console.log('%cMade with ❤️ by Alchemy Team', 'font-size: 14px; color: #EC4899;');

// ==================== PERFORMANCE OPTIMIZATION ====================
// Lazy loading images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src || img.src;
                img.classList.add('loaded');
                imageObserver.unobserve(img);
            }
        });
    });

    const images = document.querySelectorAll('img');
    images.forEach(img => imageObserver.observe(img));
}

// ==================== PRELOADER (Optional) ====================
window.addEventListener('load', function() {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});

// ==================== ERROR HANDLING ====================
window.addEventListener('error', function(e) {
    console.error('An error occurred:', e.message);
});

// ==================== ACCESSIBILITY ====================
// Skip to main content
const skipLink = document.querySelector('.skip-to-main');
if (skipLink) {
    skipLink.addEventListener('click', function(e) {
        e.preventDefault();
        const main = document.querySelector('main') || document.querySelector('.hero');
        if (main) {
            main.focus();
            main.scrollIntoView({ behavior: 'smooth' });
        }
    });
}

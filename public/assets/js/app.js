/**
 * SOLYRA - Main JavaScript
 * Scroll reveal, navbar, mobile menu, utilities
 */

(function() {
    'use strict';

    // =========================================
    // NAVBAR - Scroll effect & Mobile toggle
    // =========================================
    const navbar = document.getElementById('navbar');
    const navbarToggle = document.getElementById('navbar-toggle');
    const navbarNav = document.getElementById('navbar-nav');

    // Scroll effect
    function handleScroll() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll(); // Check on load

    // Mobile toggle
    if (navbarToggle) {
        navbarToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navbarNav.classList.toggle('open');
            document.body.style.overflow = navbarNav.classList.contains('open') ? 'hidden' : '';
        });

        // Close on link click
        navbarNav.querySelectorAll('.navbar-link').forEach(function(link) {
            link.addEventListener('click', function() {
                navbarToggle.classList.remove('active');
                navbarNav.classList.remove('open');
                document.body.style.overflow = '';
            });
        });
    }

    // =========================================
    // SCROLL REVEAL
    // =========================================
    function initScrollReveal() {
        const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
        
        if (!reveals.length) return;

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        reveals.forEach(function(el) {
            observer.observe(el);
        });
    }

    // =========================================
    // LAZY LOADING (fallback for older browsers)
    // =========================================
    function initLazyLoading() {
        if ('loading' in HTMLImageElement.prototype) return; // Native support

        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        
        const imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    imageObserver.unobserve(img);
                }
            });
        });

        lazyImages.forEach(function(img) {
            imageObserver.observe(img);
        });
    }

    // =========================================
    // SMOOTH SCROLL for anchor links
    // =========================================
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    const offset = navbar ? navbar.offsetHeight : 0;
                    const position = target.getBoundingClientRect().top + window.scrollY - offset;
                    
                    window.scrollTo({
                        top: position,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // =========================================
    // FLASH MESSAGE auto-dismiss
    // =========================================
    function initFlashMessages() {
        const flash = document.getElementById('flash-msg');
        if (flash) {
            setTimeout(function() {
                flash.style.opacity = '0';
                flash.style.transform = 'translateX(20px)';
                setTimeout(function() {
                    flash.remove();
                }, 300);
            }, 5000);
        }
    }

    // =========================================
    // PARALLAX (subtle on hero)
    // =========================================
    function initParallax() {
        const heroBg = document.querySelector('.hero-bg');
        if (!heroBg) return;

        window.addEventListener('scroll', function() {
            const scrolled = window.scrollY;
            if (scrolled < window.innerHeight) {
                heroBg.style.transform = 'translateY(' + (scrolled * 0.3) + 'px)';
            }
        }, { passive: true });
    }

    // =========================================
    // CATEGORY ICONS (emoji mapping)
    // =========================================
    function initCategoryIcons() {
        const iconMap = {
            'lightbulb': '💡',
            'gift': '🎁',
            'palette': '🎨',
            'brush': '🖌️',
            'pokeball': '⚡',
            'gamepad': '🎮',
            'briefcase': '💼',
            'trophy': '🏆'
        };

        document.querySelectorAll('.category-icon').forEach(function(el) {
            const icon = el.dataset.icon;
            if (iconMap[icon]) {
                el.textContent = iconMap[icon];
            }
        });
    }

    // =========================================
    // INITIALIZE
    // =========================================
    document.addEventListener('DOMContentLoaded', function() {
        initScrollReveal();
        initLazyLoading();
        initSmoothScroll();
        initFlashMessages();
        initParallax();
        initCategoryIcons();
    });

})();

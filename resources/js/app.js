import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Enhanced JavaScript for website interactions
document.addEventListener('DOMContentLoaded', function() {
    // Back to Top Button
    const backToTopButton = document.createElement('button');
    backToTopButton.className = 'back-to-top';
    backToTopButton.innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    `;
    backToTopButton.setAttribute('aria-label', 'Back to top');
    document.body.appendChild(backToTopButton);

    // Show/hide back to top button
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    });

    // Smooth scroll to top
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Scroll Reveal Animation
    const scrollRevealElements = document.querySelectorAll('.scroll-reveal');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                revealObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    scrollRevealElements.forEach(element => {
        revealObserver.observe(element);
    });

    // Add scroll reveal to cards and sections
    const cards = document.querySelectorAll('.card-modern, .bg-white.rounded-2xl, .bg-white.rounded-lg');
    cards.forEach((card, index) => {
        card.classList.add('scroll-reveal');
        card.style.transitionDelay = `${index * 0.1}s`;
        revealObserver.observe(card);
    });

    // Enhanced form interactions
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        // Add focus animation
        input.addEventListener('focus', function() {
            this.parentElement?.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement?.classList.remove('focused');
            }
        });

        // Add filled class if input has value
        if (input.value) {
            input.parentElement?.classList.add('filled');
        }
    });

    // Smooth anchor link scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Add loading states to buttons
    const buttons = document.querySelectorAll('button[type="submit"], a.btn-primary-enhanced, button.btn-primary-enhanced');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.type === 'submit' && this.form?.checkValidity()) {
                this.classList.add('loading');
                const originalText = this.innerHTML;
                this.innerHTML = `
                    <svg class="animate-spin h-5 w-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Loading...
                `;
                
                // Reset after 3 seconds if form doesn't submit (fallback)
                setTimeout(() => {
                    if (this.classList.contains('loading')) {
                        this.classList.remove('loading');
                        this.innerHTML = originalText;
                    }
                }, 3000);
            }
        });
    });

    // Parallax effect ONLY for hero slider background images (not content)
    // Only apply to the actual slider container, not content sections
    const heroSliderContainer = document.querySelector('.hero-slider-container');
    if (heroSliderContainer) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            // Only apply parallax to the slider container itself (background images)
            const rate = scrolled * 0.3;
            heroSliderContainer.style.transform = `translateY(${rate}px)`;
        });
    }
    
    // Prevent parallax/movement on all content sections
    const preventMovement = function() {
        // Booking progress container and all its children
        const bookingProgressContainer = document.querySelector('.booking-progress-container');
        if (bookingProgressContainer) {
            bookingProgressContainer.style.transform = 'none';
            bookingProgressContainer.style.position = 'static';
            // Prevent transforms on all children
            const children = bookingProgressContainer.querySelectorAll('*');
            children.forEach(child => {
                child.style.transform = 'none';
            });
        }
        
        // Main page hero content (the content div, not the slider)
        const heroContent = document.querySelector('.relative.z-10.py-24');
        if (heroContent && !heroContent.closest('.hero-slider-container')) {
            heroContent.style.transform = 'none';
            heroContent.style.willChange = 'auto';
        }
        
        // Footer and all its content
        const footer = document.querySelector('footer');
        if (footer) {
            footer.style.transform = 'none';
            footer.style.willChange = 'auto';
            const footerContent = footer.querySelector('.relative.z-10');
            if (footerContent) {
                footerContent.style.transform = 'none';
                footerContent.style.willChange = 'auto';
            }
            // Prevent transforms on all footer children
            const footerChildren = footer.querySelectorAll('*');
            footerChildren.forEach(child => {
                child.style.transform = 'none';
            });
        }
        
        // All step indicators in booking
        const stepIndicators = document.querySelectorAll('.booking-progress-container .relative.z-10');
        stepIndicators.forEach(step => {
            step.style.transform = 'none';
            step.style.willChange = 'auto';
        });
    };
    
    // Run on load and scroll
    preventMovement();
    window.addEventListener('scroll', preventMovement);
    window.addEventListener('resize', preventMovement);
    
    // Also run after a short delay to catch any dynamic content
    setTimeout(preventMovement, 100);
    setTimeout(preventMovement, 500);

    // Add intersection observer for fade-in animations
    const fadeElements = document.querySelectorAll('.fade-in, .animate-fade-in');
    const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeIn 0.6s ease-out';
                fadeObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    fadeElements.forEach(element => {
        fadeObserver.observe(element);
    });

    // Enhanced mobile menu interactions
    const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('hidden');
            
            // Add animation
            if (!isExpanded) {
                mobileMenu.style.animation = 'slideInRight 0.3s ease-out';
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                if (!mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                }
            }
        });
    }

    // Add hover effects to cards
    const cardsWithHover = document.querySelectorAll('.card-modern, .bg-white.rounded-lg, .bg-white.rounded-2xl');
    cardsWithHover.forEach(card => {
        card.classList.add('hover-lift');
    });

    // Console welcome message
    console.log('%c🚀 SkyBridge Website', 'color: #8B5A2B; font-size: 20px; font-weight: bold;');
    console.log('%cWebsite enhanced with modern animations and interactions!', 'color: #666; font-size: 12px;');
});
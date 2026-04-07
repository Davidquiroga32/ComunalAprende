// ============================================
// COMUNAL APRENDE - JavaScript Principal
// ============================================

// Estado global
let currentSlide = 0;
let slideInterval;

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', () => {
    initializeSlider();
    initializeMobileMenu();
    initializeScrollEffects();
    initializeAnimations();
});

// ============================================
// SLIDER PRINCIPAL
// ============================================
function initializeSlider() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    
    if (slides.length === 0) return;
    
    // Click en dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
            resetSlideInterval();
        });
    });
    
    // Auto-play
    startSlideInterval();
    
    // Pausar en hover
    const slider = document.getElementById('heroSlider');
    if (slider) {
        slider.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });
        
        slider.addEventListener('mouseleave', () => {
            startSlideInterval();
        });
    }
}

function goToSlide(index) {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    
    // Remover active de todos
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    // Agregar active al seleccionado
    slides[index].classList.add('active');
    dots[index].classList.add('active');
    
    currentSlide = index;
}

function nextSlide() {
    const slides = document.querySelectorAll('.slide');
    currentSlide = (currentSlide + 1) % slides.length;
    goToSlide(currentSlide);
}

function startSlideInterval() {
    slideInterval = setInterval(nextSlide, 4000); //Tiempo de cambio del slider
}

function resetSlideInterval() {
    clearInterval(slideInterval);
    startSlideInterval();
}

// ============================================
// MENÚ MÓVIL
// ============================================
function initializeMobileMenu() {
    const toggle = document.getElementById('mobileMenuToggle');
    const menu = document.getElementById('navMenu');
    
    if (!toggle || !menu) return;
    
    toggle.addEventListener('click', () => {
        menu.classList.toggle('active');
        
        // Cambiar icono
        const icon = toggle.querySelector('i');
        if (menu.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });
    
    // Cerrar menú al hacer click en un enlace
    const menuLinks = menu.querySelectorAll('a');
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.remove('active');
            const icon = toggle.querySelector('i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        });
    });
}

// ============================================
// EFECTOS DE SCROLL
// ============================================
function initializeScrollEffects() {
    const header = document.getElementById('header');
    
    if (!header) return;
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
}

// ============================================
// ANIMACIONES DE ENTRADA
// ============================================
function initializeAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observar elementos que deben animarse
    const animatedElements = document.querySelectorAll('.course-card, .about-card');
    animatedElements.forEach(el => observer.observe(el));
}

// ============================================
// FILTROS DE CURSOS
// ============================================
function filterCourses() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const typeFilter = document.getElementById('typeFilter');
    const courseCards = document.querySelectorAll('.course-card');
    
    if (!searchInput || !courseCards.length) return;
    
    const searchTerm = searchInput.value.toLowerCase();
    const selectedCategory = categoryFilter ? categoryFilter.value : 'all';
    const selectedType = typeFilter ? typeFilter.value : 'all';
    
    courseCards.forEach(card => {
        const title = card.querySelector('.course-title')?.textContent.toLowerCase() || '';
        const description = card.querySelector('.course-description')?.textContent.toLowerCase() || '';
        const category = card.dataset.category || '';
        const type = card.dataset.type || '';
        
        const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
        const matchesCategory = selectedCategory === 'all' || category === selectedCategory;
        const matchesType = selectedType === 'all' || type === selectedType;
        
        if (matchesSearch && matchesCategory && matchesType) {
            card.style.display = 'block';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 10);
        } else {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.display = 'none';
            }, 300);
        }
    });
}

// ============================================
// VALIDACIÓN DE FORMULARIOS
// ============================================
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            showFieldError(input, 'Este campo es requerido');
        } else {
            clearFieldError(input);
            
            // Validaciones específicas
            if (input.type === 'email' && !isValidEmail(input.value)) {
                isValid = false;
                showFieldError(input, 'Email inválido');
            }
            
            if (input.type === 'password' && input.value.length < 6) {
                isValid = false;
                showFieldError(input, 'La contraseña debe tener al menos 6 caracteres');
            }
        }
    });
    
    return isValid;
}

function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function showFieldError(input, message) {
    clearFieldError(input);
    
    input.style.borderColor = 'var(--acento-rojo)';
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = 'var(--acento-rojo)';
    errorDiv.style.fontSize = '0.85rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    input.parentNode.appendChild(errorDiv);
}

function clearFieldError(input) {
    input.style.borderColor = '';
    const existingError = input.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// ============================================
// SMOOTH SCROLL
// ============================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href !== '') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// ============================================
// UTILIDADES
// ============================================

// Mostrar notificación
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? 'var(--acento-verde)' : 'var(--acento-rojo)'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-lg);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Agregar animaciones CSS para notificaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// ============================================
// EXPORTAR FUNCIONES PARA USO GLOBAL
// ============================================
window.filterCourses = filterCourses;
window.validateForm = validateForm;
window.showNotification = showNotification;
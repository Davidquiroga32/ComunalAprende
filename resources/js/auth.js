// ============================================
// COMUNAL APRENDE - JavaScript de Autenticación
// ============================================

// ============================================
// LOGIN
// ============================================
function handleLogin(event) {
    event.preventDefault();
    
    const form = event.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const email = form.email.value;
    const password = form.password.value;
    const remember = form.remember.checked;
    
    // Validación básica
    if (!email || !password) {
        showNotification('Por favor completa todos los campos', 'error');
        return;
    }
    
    // Validar email
    if (!isValidEmail(email)) {
        showNotification('Por favor ingresa un email válido', 'error');
        return;
    }
    
    // Mostrar loading
    submitButton.classList.add('loading');
    submitButton.disabled = true;
    
    // Simular llamada al servidor
    setTimeout(() => {
        // Aquí iría la lógica real de autenticación con Laravel
        console.log('Login attempt:', { email, password, remember });
        
        // Simular éxito
        showNotification('¡Bienvenido! Redirigiendo...', 'success');
        
        // Guardar en localStorage (en producción esto vendría del servidor)
        const userData = {
            email: email,
            name: 'Usuario Demo',
            role: 'student',
            token: 'demo-token-' + Date.now()
        };
        
        if (remember) {
            localStorage.setItem('user', JSON.stringify(userData));
        } else {
            sessionStorage.setItem('user', JSON.stringify(userData));
        }
        
        // Redireccionar al dashboard
        setTimeout(() => {
            window.location.href = 'dashboard-estudiante.html';
        }, 1500);
    }, 1500);
}

// ============================================
// REGISTRO
// ============================================
function handleRegister(event) {
    event.preventDefault();
    
    const form = event.target;
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Obtener valores
    const formData = {
        firstName: form.firstName.value,
        lastName: form.lastName.value,
        email: form.email.value,
        phone: form.phone.value,
        userType: form.userType.value,
        city: form.city.value,
        password: form.password.value,
        confirmPassword: form.confirmPassword.value,
        terms: form.terms.checked,
        newsletter: form.newsletter.checked
    };
    
    // Validaciones
    if (!validateRegisterForm(formData)) {
        return;
    }
    
    // Mostrar loading
    submitButton.classList.add('loading');
    submitButton.disabled = true;
    
    // Simular llamada al servidor
    setTimeout(() => {
        // Aquí iría la lógica real de registro con Laravel
        console.log('Register attempt:', formData);
        
        // Simular éxito
        showNotification('¡Cuenta creada exitosamente!', 'success');
        
        // Guardar datos del usuario
        const userData = {
            email: formData.email,
            name: `${formData.firstName} ${formData.lastName}`,
            role: 'student',
            token: 'demo-token-' + Date.now()
        };
        
        localStorage.setItem('user', JSON.stringify(userData));
        
        // Redireccionar al dashboard
        setTimeout(() => {
            window.location.href = 'dashboard-estudiante.html';
        }, 1500);
    }, 1500);
}

function validateRegisterForm(formData) {
    // Validar campos requeridos
    if (!formData.firstName || !formData.lastName || !formData.email || 
        !formData.phone || !formData.userType || !formData.city || 
        !formData.password || !formData.confirmPassword) {
        showNotification('Por favor completa todos los campos requeridos', 'error');
        return false;
    }
    
    // Validar email
    if (!isValidEmail(formData.email)) {
        showNotification('Por favor ingresa un email válido', 'error');
        return false;
    }
    
    // Validar contraseña
    if (formData.password.length < 8) {
        showNotification('La contraseña debe tener al menos 8 caracteres', 'error');
        return false;
    }
    
    // Validar que las contraseñas coincidan
    if (formData.password !== formData.confirmPassword) {
        showNotification('Las contraseñas no coinciden', 'error');
        return false;
    }
    
    // Validar términos y condiciones
    if (!formData.terms) {
        showNotification('Debes aceptar los términos y condiciones', 'error');
        return false;
    }
    
    return true;
}

// ============================================
// UTILIDADES
// ============================================

function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    
    if (!password) {
        strengthFill.className = 'strength-fill';
        strengthFill.style.width = '0%';
        strengthText.textContent = '';
        return;
    }
    
    let strength = 0;
    
    // Verificar longitud
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    
    // Verificar mayúsculas
    if (/[A-Z]/.test(password)) strength++;
    
    // Verificar minúsculas
    if (/[a-z]/.test(password)) strength++;
    
    // Verificar números
    if (/[0-9]/.test(password)) strength++;
    
    // Verificar caracteres especiales
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    // Calcular nivel
    let level = 'weak';
    let text = 'Débil';
    
    if (strength >= 4) {
        level = 'medium';
        text = 'Media';
    }
    
    if (strength >= 6) {
        level = 'strong';
        text = 'Fuerte';
    }
    
    strengthFill.className = 'strength-fill ' + level;
    strengthText.textContent = 'Fortaleza: ' + text;
}

function socialLogin(provider) {
    showNotification(`Conectando con ${provider}...`, 'info');
    
    // Aquí iría la lógica real de OAuth
    console.log('Social login with:', provider);
    
    // Simular
    setTimeout(() => {
        showNotification('Función en desarrollo', 'error');
    }, 1000);
}

// ============================================
// VERIFICAR SESIÓN
// ============================================
function checkAuth() {
    const user = localStorage.getItem('user') || sessionStorage.getItem('user');
    
    if (user) {
        try {
            const userData = JSON.parse(user);
            return userData;
        } catch (e) {
            console.error('Error parsing user data:', e);
            return null;
        }
    }
    
    return null;
}

function logout() {
    localStorage.removeItem('user');
    sessionStorage.removeItem('user');
    showNotification('Sesión cerrada exitosamente', 'success');
    setTimeout(() => {
        window.location.href = '../index.html';
    }, 1000);
}

// Verificar si hay una sesión activa al cargar páginas protegidas
function requireAuth() {
    const user = checkAuth();
    
    if (!user) {
        showNotification('Debes iniciar sesión para acceder', 'error');
        setTimeout(() => {
            window.location.href = 'login.html';
        }, 1500);
        return false;
    }
    
    return true;
}

// ============================================
// EXPORTAR FUNCIONES
// ============================================
window.handleLogin = handleLogin;
window.handleRegister = handleRegister;
window.togglePassword = togglePassword;
window.checkPasswordStrength = checkPasswordStrength;
window.socialLogin = socialLogin;
window.checkAuth = checkAuth;
window.logout = logout;
window.requireAuth = requireAuth;
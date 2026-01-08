// Elementos del DOM
const form = document.getElementById('contactForm');
const nombreInput = document.getElementById('nombre');
const emailInput = document.getElementById('email');
const mensajeInput = document.getElementById('mensaje');
const submitBtn = document.getElementById('submitBtn');
const btnLoader = document.getElementById('btnLoader');
const successMessage = document.getElementById('successMessage');
const resetBtn = document.getElementById('resetBtn');
const floatingHelp = document.getElementById('floatingHelp');

// Elementos de error
const nombreError = document.getElementById('nombreError');
const emailError = document.getElementById('emailError');
const mensajeError = document.getElementById('mensajeError');

// Estado del formulario
let isSubmitting = false;

// Expresión regular para validar email
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

/**
 * Muestra el mensaje de ayuda flotante cuando el usuario escribe en el campo mensaje
 */
mensajeInput.addEventListener('focus', () => {
    floatingHelp.classList.add('show');
});

mensajeInput.addEventListener('blur', () => {
    floatingHelp.classList.remove('show');
});

mensajeInput.addEventListener('input', () => {
    if (mensajeInput.value.length > 0) {
        floatingHelp.classList.add('show');
    }
});

/**
 * Limpia los errores cuando el usuario comienza a escribir
 */
nombreInput.addEventListener('input', () => {
    clearError(nombreInput, nombreError);
});

emailInput.addEventListener('input', () => {
    clearError(emailInput, emailError);
});

mensajeInput.addEventListener('input', () => {
    clearError(mensajeInput, mensajeError);
});

/**
 * Limpia el error de un campo específico
 */
function clearError(input, errorElement) {
    input.classList.remove('error');
    errorElement.classList.remove('show');
    errorElement.textContent = '';
}

/**
 * Muestra un error en un campo específico
 */
function showError(input, errorElement, message) {
    input.classList.add('error');
    errorElement.textContent = message;
    errorElement.classList.add('show');
}

/**
 * Valida el campo nombre
 */
function validateNombre() {
    const nombre = nombreInput.value.trim();
    
    if (nombre === '') {
        showError(nombreInput, nombreError, 'El nombre es obligatorio');
        return false;
    }
    
    if (nombre.length < 2) {
        showError(nombreInput, nombreError, 'El nombre debe tener al menos 2 caracteres');
        return false;
    }
    
    return true;
}

/**
 * Valida el campo email
 */
function validateEmail() {
    const email = emailInput.value.trim();
    
    if (email === '') {
        showError(emailInput, emailError, 'El email es obligatorio');
        return false;
    }
    
    if (!emailRegex.test(email)) {
        showError(emailInput, emailError, 'Por favor, introduce un email válido');
        return false;
    }
    
    return true;
}

/**
 * Valida el campo mensaje
 */
function validateMensaje() {
    const mensaje = mensajeInput.value.trim();
    
    if (mensaje === '') {
        showError(mensajeInput, mensajeError, 'El mensaje es obligatorio');
        return false;
    }
    
    if (mensaje.length < 10) {
        showError(mensajeInput, mensajeError, 'El mensaje debe tener al menos 10 caracteres');
        return false;
    }
    
    return true;
}

/**
 * Valida todo el formulario
 */
function validateForm() {
    const isNombreValid = validateNombre();
    const isEmailValid = validateEmail();
    const isMensajeValid = validateMensaje();
    
    return isNombreValid && isEmailValid && isMensajeValid;
}

/**
 * Muestra el estado de carga del botón
 */
function setLoadingState(loading) {
    isSubmitting = loading;
    
    if (loading) {
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    } else {
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
    }
}

/**
 * Muestra el mensaje de éxito
 */
function showSuccess() {
    form.classList.add('hidden');
    successMessage.classList.add('show');
    floatingHelp.classList.remove('show');
}

/**
 * Resetea el formulario
 */
function resetForm() {
    form.reset();
    form.classList.remove('hidden');
    successMessage.classList.remove('show');
    
    // Limpiar todos los errores
    clearError(nombreInput, nombreError);
    clearError(emailInput, emailError);
    clearError(mensajeInput, mensajeError);
}

/**
 * Envía los datos al backend
 */
async function submitFormData(formData) {
    try {
        const response = await fetch('/backend/api/submit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Error al enviar el formulario');
        }
        
        return data;
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}

/**
 * Maneja el envío del formulario
 */
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Prevenir múltiples envíos
    if (isSubmitting) {
        return;
    }
    
    // Validar formulario
    if (!validateForm()) {
        return;
    }
    
    // Obtener datos del formulario
    const formData = {
        nombre: nombreInput.value.trim(),
        email: emailInput.value.trim(),
        mensaje: mensajeInput.value.trim()
    };
    
    // Mostrar estado de carga
    setLoadingState(true);
    
    try {
        // Enviar datos al backend
        await submitFormData(formData);
        
        // Mostrar mensaje de éxito
        showSuccess();
    } catch (error) {
        // Mostrar error
        alert('Hubo un error al enviar el formulario. Por favor, intenta de nuevo.');
        console.error('Error al enviar formulario:', error);
    } finally {
        // Quitar estado de carga
        setLoadingState(false);
    }
});

/**
 * Maneja el botón de reset
 */
resetBtn.addEventListener('click', () => {
    resetForm();
});

/**
 * Validación en tiempo real (opcional, mejora la UX)
 */
nombreInput.addEventListener('blur', () => {
    if (nombreInput.value.trim() !== '') {
        validateNombre();
    }
});

emailInput.addEventListener('blur', () => {
    if (emailInput.value.trim() !== '') {
        validateEmail();
    }
});

mensajeInput.addEventListener('blur', () => {
    if (mensajeInput.value.trim() !== '') {
        validateMensaje();
    }
});


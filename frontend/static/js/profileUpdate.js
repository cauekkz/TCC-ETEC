/**
 * Profile update form handling
 * Includes validation and the alert system
 */

document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('update-form');
    
    if (updateForm) {
        updateForm.addEventListener('submit', handleProfileUpdate);
    }
});

async function handleProfileUpdate(event) {
    event.preventDefault();
    
    // Collect the form data
    const formData = new FormData();
    
    // Basic user data
    const name = document.getElementById('name-update').value.trim();
    const email = document.getElementById('email-update').value.trim();
    const phone = document.getElementById('phone-update').value.trim();
    
    // Basic validation
    if (!name) {
        showWarning('Nome é obrigatório');
        return;
    }
    
    if (!email) {
        showWarning('Email é obrigatório');
        return;
    }
    
    if (email && !isValidEmail(email)) {
        showWarning('Email inválido');
        return;
    }
    
    // Add the data to the FormData
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    
    // Profile picture (if selected)
    const profilePic = document.getElementById('profilePic');
    if (profilePic.files.length > 0) {
        formData.append('profile_pic', profilePic.files[0]);
    }
    
    // Address data
    const street = document.getElementById('street-update').value.trim();
    const addressNumber = document.getElementById('address-number-update').value.trim();
    const city = document.getElementById('city-update').value.trim();
    const state = document.getElementById('state-update').value.trim();
    const zipCode = document.getElementById('zip-code-update').value.trim();
    
    if (street || addressNumber || city || state || zipCode) {
        formData.append('street', street);
        formData.append('address_number', addressNumber);
        formData.append('city', city);
        formData.append('state', state);
        formData.append('zip_code', zipCode);
    }
    
    // Campuses and courses (if applicable)
    const campusSelect = document.getElementById('campus-select-1');
    if (campusSelect && campusSelect.value !== 'monstro') {
        formData.append('campus_id', campusSelect.value);
    }
    
    try {
        // Mostrar loading
        const submitBtn = updateForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Atualizando...';
        
        // Send the request to update the profile
        const response = await fetch('/api/profile/update', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('jwt_token')}`
            },
            body: formData
        });
        
        if (!response.ok) {
            const errorData = await response.json();
            throw errorData;
        }
        
        const result = await response.json();
        
        if (result.status === 'success') {
            showSuccess('Perfil atualizado com sucesso!');
            
            // Close the modal after success
            setTimeout(() => {
                const modal = document.querySelector('dialog');
                if (modal) {
                    modal.close();
                }
                
                // Reload user info
                if (typeof loadUserInformation === 'function') {
                    loadUserInformation('mine');
                }
            }, 1500);
            
        } else {
            showBackendError(result, 'Erro ao atualizar perfil');
        }
        
    } catch (error) {
        console.error('Error updating profile:', error);
        showBackendError(error, 'Erro ao atualizar perfil. Tente novamente.');
        
    } finally {
        // Restore the button
        const submitBtn = updateForm.querySelector('button[type="submit"]');
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
}

/**
 * Checks whether the email has a valid format
 * @param {string} email - Email to validate
 * @returns {boolean} - True if valid, false otherwise
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Checks whether the CEP (Brazilian ZIP code) has a valid format
 * @param {string} cep - CEP to validate
 * @returns {boolean} - True if valid, false otherwise
 */
function isValidCEP(cep) {
    const cepRegex = /^\d{5}-?\d{3}$/;
    return cepRegex.test(cep);
}

/**
 * Formats the CEP automatically
 * @param {string} cep - CEP to format
 * @returns {string} - Formatted CEP
 */
function formatCEP(cep) {
    return cep.replace(/(\d{5})(\d{3})/, '$1-$2');
}

// Apply automatic CEP formatting
document.addEventListener('DOMContentLoaded', function() {
    const zipCodeInput = document.getElementById('zip-code-update');
    if (zipCodeInput) {
        zipCodeInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 8) {
                if (value.length === 8) {
                    value = formatCEP(value);
                }
                e.target.value = value;
            }
        });
    }
    
    // Phone formatting
    const phoneInput = document.getElementById('phone-update');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length === 11) {
                    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                } else if (value.length === 10) {
                    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                }
                e.target.value = value;
            }
        });
    }
});

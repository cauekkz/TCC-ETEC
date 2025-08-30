/**
 * Gerenciamento do formulário de atualização de perfil
 * Inclui validações e sistema de alertas
 */

document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('update-form');
    
    if (updateForm) {
        updateForm.addEventListener('submit', handleProfileUpdate);
    }
});

async function handleProfileUpdate(event) {
    event.preventDefault();
    
    // Coletar dados do formulário
    const formData = new FormData();
    
    // Dados básicos do usuário
    const name = document.getElementById('name-update').value.trim();
    const email = document.getElementById('email-update').value.trim();
    const phone = document.getElementById('phone-update').value.trim();
    
    // Validações básicas
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
    
    // Adicionar dados ao FormData
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    
    // Foto de perfil (se selecionada)
    const profilePic = document.getElementById('profilePic');
    if (profilePic.files.length > 0) {
        formData.append('profile_pic', profilePic.files[0]);
    }
    
    // Dados de endereço
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
    
    // Campus e cursos (se aplicável)
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
        
        // Fazer requisição para atualizar perfil
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
            
            // Fechar modal após sucesso
            setTimeout(() => {
                const modal = document.querySelector('dialog');
                if (modal) {
                    modal.close();
                }
                
                // Recarregar informações do usuário
                if (typeof loadUserInformation === 'function') {
                    loadUserInformation('mine');
                }
            }, 1500);
            
        } else {
            showBackendError(result, 'Erro ao atualizar perfil');
        }
        
    } catch (error) {
        console.error('Erro ao atualizar perfil:', error);
        showBackendError(error, 'Erro ao atualizar perfil. Tente novamente.');
        
    } finally {
        // Restaurar botão
        const submitBtn = updateForm.querySelector('button[type="submit"]');
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
}

/**
 * Valida se o email tem formato válido
 * @param {string} email - Email a ser validado
 * @returns {boolean} - True se válido, false caso contrário
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Valida se o CEP tem formato válido
 * @param {string} cep - CEP a ser validado
 * @returns {boolean} - True se válido, false caso contrário
 */
function isValidCEP(cep) {
    const cepRegex = /^\d{5}-?\d{3}$/;
    return cepRegex.test(cep);
}

/**
 * Formata o CEP automaticamente
 * @param {string} cep - CEP a ser formatado
 * @returns {string} - CEP formatado
 */
function formatCEP(cep) {
    return cep.replace(/(\d{5})(\d{3})/, '$1-$2');
}

// Aplicar formatação automática ao CEP
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
    
    // Formatação do telefone
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

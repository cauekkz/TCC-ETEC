

class AlertManager {
    constructor() {
        this.container = null;
        this.alerts = [];
        this.init();
    }

    init() {
        // Criar container de alertas se não existir
        if (!document.querySelector('.alert-container')) {
            this.container = document.createElement('div');
            this.container.className = 'alert-container';
            this.container.style.position = 'fixed';
            document.body.appendChild(this.container);
        } else {
            this.container = document.querySelector('.alert-container');
        }
    }

    /**
     * Exibe um alerta
     * @param {string} message - Mensagem do alerta
     * @param {string} type - Tipo do alerta (error, success, warning, info)
     * @param {number} duration - Duração em milissegundos (padrão: 4000ms)
     */
    show(message, type = 'error', duration = 4000) {
        // Remover todos os alertas existentes antes de mostrar um novo
        this.clearAll();
        
        const alert = this.createAlert(message, type);
        this.container.appendChild(alert);
        this.alerts.push(alert);

        // Auto-remove após duração especificada
        if (duration > 0) {
            setTimeout(() => {
                this.remove(alert);
            }, duration);
        }

        return alert;
    }

    /**
     * Cria um alerta de erro
     * @param {string} message - Mensagem de erro
     * @param {number} duration - Duração em milissegundos
     */
    error(message, duration = 4000) {
        return this.show(message, 'error', duration);
    }

    /**
     * Cria um alerta de sucesso
     * @param {string} message - Mensagem de sucesso
     * @param {number} duration - Duração em milissegundos
     */
    success(message, duration = 3000) {
        return this.show(message, 'success', duration);
    }

    /**
     * Cria um alerta de aviso
     * @param {string} message - Mensagem de aviso
     * @param {number} duration - Duração em milissegundos
     */
    warning(message, duration = 4000) {
        return this.show(message, 'warning', duration);
    }

    /**
     * Cria um alerta informativo
     * @param {string} message - Mensagem informativa
     * @param {number} duration - Duração em milissegundos
     */
    info(message, duration = 4000) {
        return this.show(message, 'info', duration);
    }

    /**
     * Cria o elemento HTML do alerta
     * @param {string} message - Mensagem do alerta
     * @param {string} type - Tipo do alerta
     */
    createAlert(message, type) {
        const alert = document.createElement('div');
        alert.className = `alert ${type}`;
        
        const icons = {
            error: '⚠️',
            success: '✅',
            warning: '⚠️',
            info: 'ℹ️'
        };

        const titles = {
            error: 'Erro',
            success: 'Sucesso',
            warning: 'Aviso',
            info: 'Informação'
        };

        alert.innerHTML = `
            <div class="alert-header">
                <span class="alert-title">
                    <span class="alert-icon">${icons[type]}</span>
                    ${titles[type]}
                </span>
                <button class="alert-close" onclick="alertManager.remove(this.parentElement.parentElement)">×</button>
            </div>
            <p class="alert-message">${this.escapeHtml(message)}</p>
        `;

        return alert;
    }

    /**
     * Remove um alerta específico
     * @param {HTMLElement} alert - Elemento do alerta a ser removido
     */
    remove(alert) {
        if (!alert || !alert.classList.contains('alert')) return;

        alert.classList.add('removing');
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
                this.alerts = this.alerts.filter(a => a !== alert);
            }
        }, 300);
    }

    /**
     * Remove todos os alertas
     */
    clearAll() {
        this.alerts.forEach(alert => {
            this.remove(alert);
        });
    }

    /**
     * Escapa HTML para evitar XSS
     * @param {string} text - Texto a ser escapado
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Exibe erro do backend de forma inteligente
     * @param {Object|string} error - Erro do backend
     * @param {string} fallbackMessage - Mensagem padrão se não conseguir extrair a mensagem
     */
    showBackendError(error, fallbackMessage = 'Ocorreu um erro inesperado') {
        let message = fallbackMessage;

        if (typeof error === 'string') {
            message = error;
        } else if (error && typeof error === 'object') {
            if (error.data) {
                message = error.data[0];
            } else if (error.error_message) {
                message = error.error_message;
            }
        }
        return this.error(message);
    }

    /**
     * Exibe sucesso do backend
     * @param {Object|string} response - Resposta do backend
     * @param {string} fallbackMessage - Mensagem padrão se não conseguir extrair a mensagem
     */
    showBackendSuccess(response, fallbackMessage = 'Operação realizada com sucesso') {
        let message = fallbackMessage;

        if (typeof response === 'string') {
            message = response;
        } else if (response && typeof response === 'object') {
            if (response.message) {
                message = response.message;
            } else if (response.msg) {
                message = response.msg;
            } else if (response.data && response.data.message) {
                message = response.data.message;
            }
        }

        return this.success(message);
    }

    /**
     * Exibe erros de validação de campos específicos
     * @param {Object} validationErrors - Objeto com erros de validação por campo
     * @param {string} fallbackMessage - Mensagem padrão se não conseguir extrair a mensagem
     */
    showValidationErrors(validationErrors, fallbackMessage = 'Erro de validação') {
        if (!validationErrors || typeof validationErrors !== 'object') {
            return this.error(fallbackMessage);
        }

        // Se é um array de erros
        if (Array.isArray(validationErrors)) {
            if (validationErrors.length > 0) {
                return this.error(validationErrors[0]);
            }
        }

        // Se é um objeto com erros por campo
        const fieldNames = Object.keys(validationErrors);
        if (fieldNames.length > 0) {
            const firstField = fieldNames[0];
            const fieldError = validationErrors[firstField];
            
            // Se o erro do campo é um array, pegar o primeiro
            if (Array.isArray(fieldError)) {
                return this.error(`${firstField}: ${fieldError[0]}`);
            } else {
                return this.error(`${firstField}: ${fieldError}`);
            }
        }

        return this.error(fallbackMessage);
    }
}

const alertManager = new AlertManager();

// Funções de conveniência para uso global
function showAlert(message, type = 'error', duration = 4000) {
    return alertManager.show(message, type, duration);
}

function showError(message, duration = 4000) {
    return alertManager.error(message, duration);
}

function showSuccess(message, duration = 3000) {
    return alertManager.success(message, duration);
}

function showWarning(message, duration = 4000) {
    return alertManager.warning(message, duration);
}

function showInfo(message, duration = 4000) {
    return alertManager.info(message, duration);
}

function showBackendError(error, fallbackMessage) {
    return alertManager.showBackendError(error, fallbackMessage);
}

function showBackendSuccess(response, fallbackMessage) {
    return alertManager.showBackendSuccess(response, fallbackMessage);
}

function showValidationErrors(validationErrors, fallbackMessage) {
    return alertManager.showValidationErrors(validationErrors, fallbackMessage);
}
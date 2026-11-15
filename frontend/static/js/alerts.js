

class AlertManager {
    constructor() {
        this.container = null;
        this.alerts = [];
        this.init();
    }

    init() {
        // Create the alerts container if it doesn't exist
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
     * Shows an alert
     * @param {string} message - Alert message
     * @param {string} type - Alert type (error, success, warning, info)
     * @param {number} duration - Duration in milliseconds (default: 4000ms)
     */
    show(message, type = 'error', duration = 4000) {
        // Remove every existing alert before showing a new one
        this.clearAll();
        
        const alert = this.createAlert(message, type);
        this.container.appendChild(alert);
        this.alerts.push(alert);

        // Auto-remove after the given duration
        if (duration > 0) {
            setTimeout(() => {
                this.remove(alert);
            }, duration);
        }

        return alert;
    }

    /**
     * Creates an error alert
     * @param {string} message - Error message
     * @param {number} duration - Duration in milliseconds
     */
    error(message, duration = 4000) {
        console.log(message)
        return this.show(message, 'error', duration);
    }

    /**
     * Creates a success alert
     * @param {string} message - Success message
     * @param {number} duration - Duration in milliseconds
     */
    success(message, duration = 3000) {
        return this.show(message, 'success', duration);
    }

    /**
     * Creates a warning alert
     * @param {string} message - Warning message
     * @param {number} duration - Duration in milliseconds
     */
    warning(message, duration = 4000) {
        return this.show(message, 'warning', duration);
    }

    /**
     * Creates an info alert
     * @param {string} message - Info message
     * @param {number} duration - Duration in milliseconds
     */
    info(message, duration = 4000) {
        return this.show(message, 'info', duration);
    }

    /**
     * Creates the alert's HTML element
     * @param {string} message - Alert message
     * @param {string} type - Alert type
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
     * Removes a specific alert
     * @param {HTMLElement} alert - Alert element to remove
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
     * Removes every alert
     */
    clearAll() {
        this.alerts.forEach(alert => {
            this.remove(alert);
        });
    }

    /**
     * Escapes HTML to prevent XSS
     * @param {string} text - Text to escape
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = String(text);
        return div.innerHTML;
    }

    /**
     * Smartly shows a backend error
     * @param {Object|string} error - Backend error
     * @param {string} fallbackMessage - Default message if none can be extracted
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
        console.log(error)
        return this.error(message);
    }

    /**
     * Shows a backend success message
     * @param {Object|string} response - Backend response
     * @param {string} fallbackMessage - Default message if none can be extracted
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
     * Shows validation errors for specific fields
     * @param {Object} validationErrors - Object with validation errors per field
     * @param {string} fallbackMessage - Default message if none can be extracted
     */
    showValidationErrors(validationErrors, fallbackMessage = 'Erro de validação') {
        if (!validationErrors || typeof validationErrors !== 'object') {
            return this.error(fallbackMessage);
        }

        // If it's an array of errors
        if (Array.isArray(validationErrors)) {
            if (validationErrors.length > 0) {
                return this.error(validationErrors[0]);
            }
        }

        // If it's an object with errors per field
        const fieldNames = Object.keys(validationErrors);
        if (fieldNames.length > 0) {
            const firstField = fieldNames[0];
            const fieldError = validationErrors[firstField];
            
            // If the field error is an array, take the first one
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

// Convenience functions for global use
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
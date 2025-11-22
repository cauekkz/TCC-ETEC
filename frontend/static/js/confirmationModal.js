/**
 * Sistema de Modal de Confirmação - EteConnect
 * Modal reutilizável para confirmação de ações importantes
 */

class ConfirmationModal {
    constructor() {
        this.modal = null;
        this.resolvePromise = null;
        this.init();
    }

    init() {
        // Cria o modal se não existir
        if (!document.querySelector('#confirmation-modal')) {
            this.createModal();
        } else {
            this.modal = document.querySelector('#confirmation-modal');
        }
    }

    createModal() {
        const modal = document.createElement('div');
        modal.id = 'confirmation-modal';
        modal.className = 'confirmation-modal-overlay';
        modal.innerHTML = `
            <div class="confirmation-modal-content">
                <div class="confirmation-modal-header">
                    <h3 class="confirmation-modal-title">Confirmar Ação</h3>
                    <button class="confirmation-modal-close" aria-label="Fechar">&times;</button>
                </div>
                <div class="confirmation-modal-body">
                    <p class="confirmation-modal-message"></p>
                </div>
                <div class="confirmation-modal-footer">
                    <button class="confirmation-btn confirmation-btn-no" id="confirmation-no">Não</button>
                    <button class="confirmation-btn confirmation-btn-yes" id="confirmation-yes">Sim</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        this.modal = modal;

        // Event listeners
        const closeBtn = modal.querySelector('.confirmation-modal-close');
        const noBtn = modal.querySelector('#confirmation-no');
        const yesBtn = modal.querySelector('#confirmation-yes');

        closeBtn.addEventListener('click', () => this.close(false));
        noBtn.addEventListener('click', () => this.close(false));
        yesBtn.addEventListener('click', () => this.close(true));

        // Fechar ao clicar no overlay
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                this.close(false);
            }
        });

        // Fechar com ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                this.close(false);
            }
        });
    }

    show(message, title = 'Confirmar Ação') {
        return new Promise((resolve) => {
            this.resolvePromise = resolve;
            
            const messageEl = this.modal.querySelector('.confirmation-modal-message');
            const titleEl = this.modal.querySelector('.confirmation-modal-title');
            
            messageEl.textContent = message;
            titleEl.textContent = title;
            
            this.modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    close(confirmed) {
        if (this.modal) {
            this.modal.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        if (this.resolvePromise) {
            this.resolvePromise(confirmed);
            this.resolvePromise = null;
        }
    }
}

// Instância global
let confirmationModalInstance = null;

// Função para inicializar o modal
function initConfirmationModal() {
    if (!confirmationModalInstance) {
        confirmationModalInstance = new ConfirmationModal();
        window.confirmationModal = confirmationModalInstance;
    }
    return confirmationModalInstance;
}

// Inicializa imediatamente se o DOM já estiver pronto, senão espera
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initConfirmationModal);
} else {
    // DOM já está pronto
    initConfirmationModal();
}

/**
 * Função auxiliar para confirmar ações
 * @param {string} message - Mensagem de confirmação
 * @param {string} title - Título do modal (opcional)
 * @returns {Promise<boolean>} - true se confirmado, false se cancelado
 */
async function confirmAction(message, title = 'Confirmar Ação') {
    // Garante que o modal está inicializado
    const modal = initConfirmationModal();
    return await modal.show(message, title);
}

// Torna a função global
window.confirmAction = confirmAction;


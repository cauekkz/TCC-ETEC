/**
 * Confirmation modal system - EteConnect
 * Reusable modal for confirming important actions
 */

class ConfirmationModal {
    constructor() {
        this.modal = null;
        this.resolvePromise = null;
        this.init();
    }

    init() {
        // Create the modal if it doesn't exist
        if (!document.querySelector('#confirmation-modal')) {
            this.createModal();
        } else {
            const modal = document.querySelector('#confirmation-modal');
            this.modal = document.querySelector('#confirmation-modal');
            const closeBtn = modal.querySelector('.confirmation-modal-close');
            const noBtn = modal.querySelector('#confirmation-no');
            const yesBtn = modal.querySelector('#confirmation-yes');

            closeBtn.addEventListener('click', () => this.close(false));
            noBtn.addEventListener('click', () => this.close(false));
            yesBtn.addEventListener('click', () => this.close(true));

            // Close when the overlay is clicked
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.close(false);
                }
            });

            // Close with ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    this.close(false);
                }
            });

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

        // Close when the overlay is clicked
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                this.close(false);
            }
        });

        // Close with ESC
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

// Global instance
let confirmationModalInstance = null;

// Initializes the modal
function initConfirmationModal() {
    if (!confirmationModalInstance) {
        confirmationModalInstance = new ConfirmationModal();
        window.confirmationModal = confirmationModalInstance;
    }
    return confirmationModalInstance;
}

// Initialize right away if the DOM is ready, otherwise wait
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initConfirmationModal);
} else {
    // DOM is already ready
    initConfirmationModal();
}

/**
 * Helper for confirming actions
 * @param {string} message - Confirmation message
 * @param {string} title - Modal title (optional)
 * @returns {Promise<boolean>} - true if confirmed, false if cancelled
 */
async function confirmAction(message, title = 'Confirmar Ação') {
    // Make sure the modal is initialized
    const modal = initConfirmationModal();
    return await modal.show(message, title);
}

// Make the function global
window.confirmAction = confirmAction;


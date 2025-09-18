// Dark Mode Toggle
document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;
    
    // Check for saved dark mode preference
    const savedTheme = localStorage.getItem('darkMode');
    if (savedTheme === 'enabled') {
        body.classList.add('dark-mode');
        darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
    }
    
    darkModeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');
        
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
            darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        } else {
            localStorage.setItem('darkMode', 'disabled');
            darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        }
    });
    
    // Participate button functionality
    const participateBtns = document.querySelectorAll('.participate-btn');
    participateBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const eventCard = this.closest('.event-card');
            const eventTitle = eventCard.querySelector('h3').textContent;
            
            // Check if already participating
            if (this.textContent === 'Participando') {
                this.textContent = 'Participar';
                this.style.backgroundColor = '#dc2626';
                showNotification(`Você cancelou a participação no evento: ${eventTitle}`, 'info');
            } else {
                this.textContent = 'Participando';
                this.style.backgroundColor = '#10b981';
                showNotification(`Você se inscreveu no evento: ${eventTitle}`, 'success');
            }
        });
    });
    
    // Notification functionality
    const notificationBtn = document.querySelector('.notification-btn');
    notificationBtn.addEventListener('click', function() {
        showNotification('Sistema de notificações em desenvolvimento!', 'info');
    });
    
    // Progress bar animation
    const progressBars = document.querySelectorAll('.progress-fill');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });
    
    // Event card hover effects
    const eventCards = document.querySelectorAll('.event-card');
    eventCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Mobile menu toggle (for responsive design)
    const menuToggle = document.createElement('button');
    menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
    menuToggle.className = 'menu-toggle';
    menuToggle.style.cssText = `
        display: none;
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1001;
        background-color: #dc2626;
        color: white;
        border: none;
        padding: 0.5rem;
        border-radius: 4px;
        cursor: pointer;
    `;
    
    if (window.innerWidth <= 768) {
        document.body.appendChild(menuToggle);
        menuToggle.style.display = 'block';
        
        menuToggle.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('open');
        });
    }
    
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 768) {
            menuToggle.style.display = 'block';
        } else {
            menuToggle.style.display = 'none';
            document.querySelector('.sidebar').classList.remove('open');
        }
    });
    
    // Add smooth scrolling for better UX
    document.documentElement.style.scrollBehavior = 'smooth';
});

// Notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Styles for notification
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background-color: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        z-index: 10000;
        font-weight: 500;
        max-width: 300px;
        word-wrap: break-word;
        animation: slideIn 0.3s ease;
    `;
    
    // Add animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 3000);
}

// Add event filtering functionality
function addEventFiltering() {
    const filterContainer = document.createElement('div');
    filterContainer.className = 'event-filters';
    filterContainer.style.cssText = `
        margin-bottom: 2rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    `;
    
    const filterLabel = document.createElement('span');
    filterLabel.textContent = 'Filtrar por categoria:';
    filterLabel.style.cssText = `
        font-weight: 500;
        color: #666;
    `;
    
    const allBtn = document.createElement('button');
    allBtn.textContent = 'Todos';
    allBtn.className = 'filter-btn active';
    allBtn.style.cssText = `
        padding: 0.5rem 1rem;
        border: 1px solid #dc2626;
        background-color: #dc2626;
        color: white;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    `;
    
    const educacionalBtn = document.createElement('button');
    educacionalBtn.textContent = 'Educacional';
    educacionalBtn.className = 'filter-btn';
    educacionalBtn.style.cssText = `
        padding: 0.5rem 1rem;
        border: 1px solid #dc2626;
        background-color: transparent;
        color: #dc2626;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    `;
    
    const cerimoniaBtn = document.createElement('button');
    cerimoniaBtn.textContent = 'Cerimônia';
    cerimoniaBtn.className = 'filter-btn';
    cerimoniaBtn.style.cssText = `
        padding: 0.5rem 1rem;
        border: 1px solid #dc2626;
        background-color: transparent;
        color: #dc2626;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    `;
    
    filterContainer.appendChild(filterLabel);
    filterContainer.appendChild(allBtn);
    filterContainer.appendChild(educacionalBtn);
    filterContainer.appendChild(cerimoniaBtn);
    
    // Insert after content header
    const contentHeader = document.querySelector('.content-header');
    contentHeader.insertAdjacentElement('afterend', filterContainer);
    
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const eventCards = document.querySelectorAll('.event-card');
    
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(b => {
                b.classList.remove('active');
                b.style.backgroundColor = 'transparent';
                b.style.color = '#dc2626';
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            this.style.backgroundColor = '#dc2626';
            this.style.color = 'white';
            
            const filter = this.textContent.toLowerCase();
            
            eventCards.forEach(card => {
                if (filter === 'todos') {
                    card.style.display = 'block';
                } else {
                    const category = card.querySelector('.event-category').textContent.toLowerCase();
                    if (category.includes(filter)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    });
}

// Initialize filtering after DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(addEventFiltering, 100);
    addCreateEventButton();
});

// Add create event button
function addCreateEventButton() {
    const createEventBtn = document.createElement('button');
    createEventBtn.innerHTML = '<i class="fas fa-plus"></i> <span>Criar Evento</span>';
    createEventBtn.className = 'create-event-btn';
    createEventBtn.style.cssText = `
        background-color: #dc2626;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
        margin-left: auto;
        margin-right: auto;
        display: block;
    `;
    
    // Insert create button after content header
    const contentHeader = document.querySelector('.content-header');
    contentHeader.insertAdjacentElement('afterend', createEventBtn);
    
    createEventBtn.addEventListener('click', function() {
        showCreateEventModal();
    });
}

// Show create event modal
function showCreateEventModal() {
    const modal = document.createElement('div');
    modal.className = 'create-event-modal';
    modal.innerHTML = `
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Criar Novo Evento</h2>
                    <button class="close-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="create-event-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="eventTitle">Título do Evento *</label>
                                <input type="text" id="eventTitle" placeholder="Ex: Feira de Profissões 2024" required>
                            </div>
                            <div class="form-group">
                                <label for="eventCategory">Categoria *</label>
                                <select id="eventCategory" required>
                                    <option value="">Selecione a categoria</option>
                                    <option value="educacional">Educacional</option>
                                    <option value="cerimonia">Cerimônia</option>
                                    <option value="esportivo">Esportivo</option>
                                    <option value="cultural">Cultural</option>
                                    <option value="tecnico">Técnico</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="eventDescription">Descrição *</label>
                            <textarea id="eventDescription" placeholder="Descreva o evento, objetivos e informações importantes" rows="4" required></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="eventDate">Data *</label>
                                <input type="date" id="eventDate" required>
                            </div>
                            <div class="form-group">
                                <label for="eventTime">Horário *</label>
                                <input type="time" id="eventTime" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="eventLocation">Local *</label>
                            <input type="text" id="eventLocation" placeholder="Ex: Auditório Central - ETEC Cidade Tiradentes" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="maxParticipants">Máximo de Participantes</label>
                                <input type="number" id="maxParticipants" placeholder="Ex: 300" min="1">
                            </div>
                            <div class="form-group">
                                <label for="eventType">Tipo de Evento</label>
                                <select id="eventType">
                                    <option value="presencial">Presencial</option>
                                    <option value="online">Online</option>
                                    <option value="hibrido">Híbrido</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="modal-actions">
                            <button type="button" class="action-btn secondary cancel-btn">Cancelar</button>
                            <button type="submit" class="action-btn primary">Criar Evento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;
    
    // Add modal styles
    const style = document.createElement('style');
    style.textContent = `
        .create-event-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10000;
            animation: fadeIn 0.3s ease;
        }
        
        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-y: auto;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 12px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px rgba(0,0,0,0.1);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e5e5;
        }
        
        .modal-header h2 {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin: 0;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #666;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .close-btn:hover {
            background-color: #f0f0f0;
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .create-event-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .form-group label {
            font-weight: 500;
            color: #333;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            padding: 0.75rem;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #dc2626;
        }
        
        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1rem;
        }
        
        .action-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .action-btn.primary {
            background-color: #dc2626;
            color: white;
        }
        
        .action-btn.primary:hover {
            background-color: #b91c1c;
        }
        
        .action-btn.secondary {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .action-btn.secondary:hover {
            background-color: #e5e7eb;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .modal-actions {
                flex-direction: column;
            }
        }
        
        body.dark-mode .modal-content {
            background-color: #374151;
        }
        
        body.dark-mode .modal-header {
            border-bottom-color: #4b5563;
        }
        
        body.dark-mode .modal-header h2 {
            color: #f9fafb;
        }
        
        body.dark-mode .form-group label {
            color: #f9fafb;
        }
        
        body.dark-mode .form-group input,
        body.dark-mode .form-group textarea,
        body.dark-mode .form-group select {
            background-color: #4b5563;
            border-color: #6b7280;
            color: #f9fafb;
        }
        
        body.dark-mode .form-group input:focus,
        body.dark-mode .form-group textarea:focus,
        body.dark-mode .form-group select:focus {
            border-color: #dc2626;
        }
        
        body.dark-mode .action-btn.secondary {
            background-color: #4b5563;
            color: #d1d5db;
        }
        
        body.dark-mode .action-btn.secondary:hover {
            background-color: #6b7280;
        }
    `;
    document.head.appendChild(style);
    
    document.body.appendChild(modal);
    
    // Close modal functionality
    const closeBtn = modal.querySelector('.close-btn');
    const cancelBtn = modal.querySelector('.cancel-btn');
    const overlay = modal.querySelector('.modal-overlay');
    const form = modal.querySelector('.create-event-form');
    
    closeBtn.addEventListener('click', () => modal.remove());
    cancelBtn.addEventListener('click', () => modal.remove());
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) modal.remove();
    });
    
    // Set minimum date to today
    const dateInput = document.getElementById('eventDate');
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        createEvent();
    });
}

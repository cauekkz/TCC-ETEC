/**
 * Accessibility system - EteConnect
 * Features: text-to-speech, image descriptions, font size control
 */

class AccessibilityManager {
    constructor() {
        this.settings = {
            textToSpeech: false,
            imageDescription: false,
            fontSize: 1.0, // Font size multiplier (1.0 = 100%)
            speechRate: 1.0,
            speechPitch: 1.0
        };
        this.speechSynthesis = null;
        this.currentUtterance = null;
        this.imageObserver = null;
        this.textToSpeechHandler = null;
        this.stopSpeechHandler = null;
        this.imageDescriptionHandler = null;
        this.init();
    }

    init() {
        // Load saved settings (works on every page)
        this.loadSettings();

        // Check for Web Speech API support
        if ('speechSynthesis' in window) {
            this.speechSynthesis = window.speechSynthesis;
        } else {
            console.warn('Web Speech API not supported in this browser');
        }

        // Apply initial settings (works on every page)
        this.applySettings();

        // Set up event listeners (works on every page)
        this.setupEventListeners();

        // Create the button and panel ONLY on the profile page
        if (this.isProfilePage()) {
            this.createAccessibilityButton();
            this.createSettingsPanel();
        }
    }

    isProfilePage() {
        // Check from the URL whether we're on the profile page
        const url = window.location.pathname;
        const searchParams = new URLSearchParams(window.location.search);

        // Check whether the URL contains /profile or there's a profile query parameter
        return url.includes('/profile') || searchParams.has('profile');
    }

    loadSettings() {
        const saved = localStorage.getItem('eteconnect-accessibility');
        if (saved) {
            try {
                this.settings = { ...this.settings, ...JSON.parse(saved) };
            } catch (e) {
                console.error('Error loading accessibility settings:', e);
            }
        }
    }

    saveSettings() {
        localStorage.setItem('eteconnect-accessibility', JSON.stringify(this.settings));
    }

    createAccessibilityButton() {
        // Check whether the button already exists
        if (document.querySelector('.accessibility-btn')) {
            return;
        }

        const button = document.createElement('button');
        button.className = 'accessibility-btn';
        button.setAttribute('aria-label', 'Configurações de acessibilidade');
        button.innerHTML = `
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
  <!-- CIRCLE -->
  <circle cx="12" cy="12" r="11" fill="none" stroke="currentColor" stroke-width="2"/>

  <!-- HEAD (centered) -->
  <circle cx="12" cy="6.5" r="2"/>

  <!-- ARMS (horizontal and centered) -->
  <line x1="5" y1="10" x2="19" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>

  <!-- TRONCO (centralizado) -->
  <line x1="12" y1="9" x2="12" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>

  <!-- LEGS (symmetrical) -->
  <line x1="12" y1="16" x2="8.5" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  <line x1="12" y1="16" x2="15.5" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
</svg>
        `;

        // Insert the button in the header, next to the theme button
        this.insertAccessibilityButton(button);

        // Event listener that opens the panel
        button.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.toggleSettingsPanel();
        });
    }

    insertAccessibilityButton(button) {
        const header = document.querySelector('header');
        if (!header) {
            console.warn('Header not found to insert the accessibility button');
            return;
        }

        // Insert the button directly into the header
        // Positioning is done in CSS, so it doesn't interfere with the theme button
        header.appendChild(button);
    }

    createSettingsPanel() {
        // Check whether the panel already exists
        if (document.querySelector('.accessibility-panel')) {
            return;
        }

        // Create the overlay
        const overlay = document.createElement('div');
        overlay.className = 'accessibility-overlay';
        overlay.addEventListener('click', () => this.closeSettingsPanel());
        document.body.appendChild(overlay);

        const panel = document.createElement('div');
        panel.className = 'accessibility-panel';
        panel.setAttribute('role', 'dialog');
        panel.setAttribute('aria-labelledby', 'accessibility-panel-title');
        panel.innerHTML = `
            <div class="accessibility-panel-header">
                <h3 id="accessibility-panel-title">Configurações de Acessibilidade</h3>
                <button class="accessibility-panel-close" aria-label="Fechar painel de acessibilidade">&times;</button>
            </div>
            <div class="accessibility-panel-body">
                <div class="accessibility-option">
                    <label class="accessibility-switch">
                        <input type="checkbox" id="textToSpeechToggle" ${this.settings.textToSpeech ? 'checked' : ''}>
                        <span class="slider"></span>
                        <span class="label-text">Leitura de texto ao passar o mouse</span>
                    </label>
                    <p class="accessibility-description">Ative para ouvir o texto quando passar o mouse sobre frases</p>
                </div>

                <div class="accessibility-option">
                    <label class="accessibility-switch">
                        <input type="checkbox" id="imageDescriptionToggle" ${this.settings.imageDescription ? 'checked' : ''}>
                        <span class="slider"></span>
                        <span class="label-text">Descrição de imagens ao passar o mouse</span>
                    </label>
                    <p class="accessibility-description">Ative para ouvir descrições de imagens ao passar o mouse</p>
                </div>

                <div class="accessibility-option">
                    <label for="fontSizeSlider" class="accessibility-label">Tamanho da fonte</label>
                    <div class="font-size-controls">
                        <button class="font-size-btn" id="fontSizeDecrease" aria-label="Diminuir tamanho da fonte">A-</button>
                        <input type="range" id="fontSizeSlider" min="0.8" max="1.5" step="0.1" value="${this.settings.fontSize}">
                        <button class="font-size-btn" id="fontSizeIncrease" aria-label="Aumentar tamanho da fonte">A+</button>
                        <span class="font-size-value">${Math.round(this.settings.fontSize * 100)}%</span>
                    </div>
                </div>

                <div class="accessibility-option">
                    <label for="speechRateSlider" class="accessibility-label">Velocidade da leitura</label>
                    <div class="slider-control">
                        <input type="range" id="speechRateSlider" min="0.5" max="2" step="0.1" value="${this.settings.speechRate}">
                        <span class="slider-value">${this.settings.speechRate.toFixed(1)}x</span>
                    </div>
                </div>

                <div class="accessibility-option">
                    <button class="accessibility-reset-btn" id="resetAccessibility">Restaurar padrões</button>
                </div>
            </div>
        `;

        document.body.appendChild(panel);

        // Event listeners for the controls
        this.setupPanelEventListeners(panel);
    }

    setupPanelEventListeners(panel) {
        // Fechar painel
        const closeBtn = panel.querySelector('.accessibility-panel-close');
        closeBtn.addEventListener('click', () => this.closeSettingsPanel());

        // Text-to-speech toggle
        const textToSpeechToggle = panel.querySelector('#textToSpeechToggle');
        textToSpeechToggle.addEventListener('change', (e) => {
            this.settings.textToSpeech = e.target.checked;
            this.saveSettings();
            this.applySettings();
        });

        // Image description toggle
        const imageDescriptionToggle = panel.querySelector('#imageDescriptionToggle');
        imageDescriptionToggle.addEventListener('change', (e) => {
            this.settings.imageDescription = e.target.checked;
            this.saveSettings();
            this.applySettings();
        });

        // Font size slider
        const fontSizeSlider = panel.querySelector('#fontSizeSlider');
        const fontSizeValue = panel.querySelector('.font-size-value');
        fontSizeSlider.addEventListener('input', (e) => {
            this.settings.fontSize = parseFloat(e.target.value);
            fontSizeValue.textContent = `${Math.round(this.settings.fontSize * 100)}%`;
            this.saveSettings();
            this.applyFontSize();
        });

        // Font size buttons
        const fontSizeDecrease = panel.querySelector('#fontSizeDecrease');
        const fontSizeIncrease = panel.querySelector('#fontSizeIncrease');
        fontSizeDecrease.addEventListener('click', () => {
            if (this.settings.fontSize > 0.8) {
                this.settings.fontSize = Math.max(0.8, this.settings.fontSize - 0.1);
                fontSizeSlider.value = this.settings.fontSize;
                fontSizeValue.textContent = `${Math.round(this.settings.fontSize * 100)}%`;
                this.saveSettings();
                this.applyFontSize();
            }
        });
        fontSizeIncrease.addEventListener('click', () => {
            if (this.settings.fontSize < 1.5) {
                this.settings.fontSize = Math.min(1.5, this.settings.fontSize + 0.1);
                fontSizeSlider.value = this.settings.fontSize;
                fontSizeValue.textContent = `${Math.round(this.settings.fontSize * 100)}%`;
                this.saveSettings();
                this.applyFontSize();
            }
        });

        // Speech rate slider
        const speechRateSlider = panel.querySelector('#speechRateSlider');
        const speechRateValue = panel.querySelector('.slider-value');
        speechRateSlider.addEventListener('input', (e) => {
            this.settings.speechRate = parseFloat(e.target.value);
            speechRateValue.textContent = `${this.settings.speechRate.toFixed(1)}x`;
            this.saveSettings();
        });

        // Reset button
        const resetBtn = panel.querySelector('#resetAccessibility');
        resetBtn.addEventListener('click', () => {
            this.resetSettings();
        });

        // Close when clicking outside
        panel.addEventListener('click', (e) => {
            if (e.target === panel) {
                this.closeSettingsPanel();
            }
        });
    }

    toggleSettingsPanel() {
        const panel = document.querySelector('.accessibility-panel');
        if (panel) {
            if (panel.classList.contains('active')) {
                this.closeSettingsPanel();
            } else {
                this.openSettingsPanel();
            }
        }
    }

    openSettingsPanel() {
        const panel = document.querySelector('.accessibility-panel');
        const overlay = document.querySelector('.accessibility-overlay');
        if (panel) {
            panel.classList.add('active');
            if (overlay) {
                overlay.classList.add('active');
            }
            // Update the control values
            panel.querySelector('#textToSpeechToggle').checked = this.settings.textToSpeech;
            panel.querySelector('#imageDescriptionToggle').checked = this.settings.imageDescription;
            panel.querySelector('#fontSizeSlider').value = this.settings.fontSize;
            panel.querySelector('.font-size-value').textContent = `${Math.round(this.settings.fontSize * 100)}%`;
            panel.querySelector('#speechRateSlider').value = this.settings.speechRate;
            panel.querySelector('.slider-value').textContent = `${this.settings.speechRate.toFixed(1)}x`;
        }
    }

    closeSettingsPanel() {
        const panel = document.querySelector('.accessibility-panel');
        const overlay = document.querySelector('.accessibility-overlay');
        if (panel) {
            panel.classList.remove('active');
        }
        if (overlay) {
            overlay.classList.remove('active');
        }
    }

    resetSettings() {
        this.settings = {
            textToSpeech: false,
            imageDescription: false,
            fontSize: 1.0,
            speechRate: 1.0,
            speechPitch: 1.0
        };
        this.saveSettings();
        this.applySettings();

        // Update the panel controls
        const panel = document.querySelector('.accessibility-panel');
        if (panel) {
            panel.querySelector('#textToSpeechToggle').checked = false;
            panel.querySelector('#imageDescriptionToggle').checked = false;
            panel.querySelector('#fontSizeSlider').value = 1.0;
            panel.querySelector('.font-size-value').textContent = '100%';
            panel.querySelector('#speechRateSlider').value = 1.0;
            panel.querySelector('.slider-value').textContent = '1.0x';
        }
    }

    applySettings() {
        this.applyFontSize();
        this.setupTextToSpeech();
        this.setupImageDescription();
    }

    applyFontSize() {
        document.documentElement.style.fontSize = `${this.settings.fontSize * 100}%`;
    }

    setupTextToSpeech() {
        // Remove listeners anteriores
        document.removeEventListener('mouseover', this.textToSpeechHandler);
        document.removeEventListener('mouseout', this.stopSpeechHandler);

        if (this.settings.textToSpeech && this.speechSynthesis) {
            this.textToSpeechHandler = (e) => {
                const target = e.target;
                let textToSpeak = '';

                // Interactive elements use special logic
                if (target.tagName === 'BUTTON' || target.closest('button')) {
                    const button = target.tagName === 'BUTTON' ? target : target.closest('button');
                    textToSpeak = this.getTextFromElement(button);
                }
                // Links (incluindo aside navigation)
                else if (target.tagName === 'A' || target.closest('a')) {
                    const link = target.tagName === 'A' ? target : target.closest('a');
                    textToSpeak = this.getTextFromElement(link);
                }
                // Inputs
                else if (target.tagName === 'INPUT') {
                    textToSpeak = this.getTextFromInput(target);
                }
                // Headers (h1, h2, h3, h4, h5, h6)
                else if (/^H[1-6]$/.test(target.tagName)) {
                    textToSpeak = this.getTextFromElement(target);
                }
                // Labels
                else if (target.tagName === 'LABEL') {
                    textToSpeak = this.getTextFromElement(target);
                }
                // Select elements
                else if (target.tagName === 'SELECT') {
                    const selectedOption = target.options[target.selectedIndex];
                    textToSpeak = selectedOption ? selectedOption.text : '';
                }
                // Textarea
                else if (target.tagName === 'TEXTAREA') {
                    textToSpeak = target.value || target.placeholder || '';
                }
                // Skip images (they have their own handler)
                else if (target.tagName === 'IMG') {
                    return;
                }
                // For other elements, read the text normally
                else {
                    textToSpeak = this.getTextFromElement(target);
                }

                // Speak the text if it's valid
                if (textToSpeak && textToSpeak.trim().length > 0 && textToSpeak.length < 500) {
                    this.speakText(textToSpeak.trim());
                }
            };

            this.stopSpeechHandler = () => {
                if (this.speechSynthesis && this.speechSynthesis.speaking) {
                    this.speechSynthesis.cancel();
                }
            };

            document.addEventListener('mouseover', this.textToSpeechHandler);
            document.addEventListener('mouseout', this.stopSpeechHandler);
        }
    }

    /**
     * Smartly extracts the text of an element
     * Priority: aria-label > title > textContent > aria-labelledby
     */
    getTextFromElement(element) {
        if (!element) return '';

        // 1. Prioridade: aria-label
        const ariaLabel = element.getAttribute('aria-label');
        if (ariaLabel && ariaLabel.trim()) {
            return ariaLabel.trim();
        }

        // 2. Prioridade: title
        const title = element.getAttribute('title');
        if (title && title.trim()) {
            return title.trim();
        }

        // 3. Priority: textContent (with extra whitespace removed)
        // For links and buttons, take all the text including child elements
        let textContent = '';
        if (element.tagName === 'A' || element.tagName === 'BUTTON') {
            // For links and buttons, drop SVG and icon text, keep only visible text
            const clone = element.cloneNode(true);
            // Remove SVGs and icon elements
            clone.querySelectorAll('svg, .svg-style, .icon, [class*="icon"]').forEach(el => el.remove());
            textContent = clone.textContent?.trim();
        } else {
            textContent = element.textContent?.trim();
        }

        if (textContent && textContent.length > 0) {
            // Collapse repeated spaces and line breaks
            return textContent.replace(/\s+/g, ' ').trim();
        }

        // 4. Priority: aria-labelledby (looks up the referenced element)
        const labelledBy = element.getAttribute('aria-labelledby');
        if (labelledBy) {
            const labelElement = document.getElementById(labelledBy);
            if (labelElement) {
                return this.getTextFromElement(labelElement);
            }
        }

        // 5. For inputs, try the placeholder
        if (element.tagName === 'INPUT' && element.placeholder) {
            return element.placeholder;
        }

        // 6. For buttons with no visible text, try value
        if (element.tagName === 'BUTTON' && element.value) {
            return element.value;
        }

        // 7. For empty elements, look for text in visible children
        if (!textContent || textContent.length === 0) {
            const visibleTextElements = element.querySelectorAll('p, span, div, h1, h2, h3, h4, h5, h6, label');
            for (const child of visibleTextElements) {
                const childText = child.textContent?.trim();
                if (childText && childText.length > 0) {
                    return childText.replace(/\s+/g, ' ').trim();
                }
            }
        }

        return '';
    }

    /**
     * Smartly extracts the text of input fields
     */
    getTextFromInput(input) {
        if (!input) return '';

        const type = input.type?.toLowerCase();

        // For text inputs, read the value or the placeholder
        if (type === 'text' || type === 'email' || type === 'password' || type === 'search' || type === 'tel' || type === 'url') {
            if (input.value && input.value.trim()) {
                return input.value.trim();
            }
            if (input.placeholder) {
                return `Campo: ${input.placeholder}`;
            }
            const label = this.getInputLabel(input);
            if (label) {
                return `Campo ${label}`;
            }
            return 'Campo de texto';
        }

        // For checkboxes and radio buttons
        if (type === 'checkbox' || type === 'radio') {
            const label = this.getInputLabel(input);
            const checked = input.checked ? 'marcado' : 'desmarcado';
            return label ? `${label}, ${checked}` : `Opção ${checked}`;
        }

        // For range/slider
        if (type === 'range') {
            const label = this.getInputLabel(input);
            const value = input.value || input.min || '0';
            return label ? `${label}: ${value}` : `Valor: ${value}`;
        }

        // For other types
        const label = this.getInputLabel(input);
        if (label) {
            return label;
        }
        if (input.placeholder) {
            return input.placeholder;
        }
        return 'Campo de entrada';
    }

    /**
     * Finds the label associated with an input
     */
    getInputLabel(input) {
        // Try the aria-label attribute
        const ariaLabel = input.getAttribute('aria-label');
        if (ariaLabel) return ariaLabel;

        // Try the id attribute and label[for]
        if (input.id) {
            const label = document.querySelector(`label[for="${input.id}"]`);
            if (label) {
                return label.textContent?.trim() || '';
            }
        }

        // Tenta encontrar label pai
        const parentLabel = input.closest('label');
        if (parentLabel) {
            const labelText = parentLabel.textContent?.trim();
            // Remove the input's text from the label
            return labelText.replace(input.value || '', '').trim();
        }

        // Try the placeholder
        if (input.placeholder) {
            return input.placeholder;
        }

        return '';
    }

    setupImageDescription() {
        // Remove handlers anteriores
        if (this.imageDescriptionHandler) {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.removeEventListener('mouseenter', this.imageDescriptionHandler);
                img.removeEventListener('mouseleave', this.stopSpeechHandler);
            });
        }

        if (this.settings.imageDescription && this.speechSynthesis) {
            // Create the image description handler
            this.imageDescriptionHandler = (e) => {
                const img = e.target;
                let description = '';

                // Priority: alt text > title > aria-label > default description
                if (img.alt && img.alt.trim()) {
                    description = img.alt;
                } else if (img.title && img.title.trim()) {
                    description = img.title;
                } else if (img.getAttribute('aria-label')) {
                    description = img.getAttribute('aria-label');
                } else {
                    // Try to get context for the image
                    const parent = img.parentElement;
                    if (parent) {
                        const contextText = parent.textContent?.trim();
                        if (contextText && contextText.length < 200) {
                            description = `Imagem relacionada a: ${contextText}`;
                        } else {
                            description = 'Imagem sem descrição disponível';
                        }
                    } else {
                        description = 'Imagem sem descrição disponível';
                    }
                }

                if (description) {
                    this.speakText(description);
                }
            };

            // Attach listeners to every existing image
            document.querySelectorAll('img').forEach(img => {
                this.attachImageListeners(img);
            });

            // Set up an observer for new images
            this.setupImageObserver();
        } else {
            // If disabled, disconnect the observer
            if (this.imageObserver) {
                this.imageObserver.disconnect();
                this.imageObserver = null;
            }
        }
    }

    speakText(text) {
        if (!this.speechSynthesis) {
            return;
        }

        // Cancela qualquer fala anterior
        if (this.speechSynthesis.speaking) {
            this.speechSynthesis.cancel();
        }

        // Create a new utterance
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'pt-BR';
        utterance.rate = this.settings.speechRate;
        utterance.pitch = this.settings.speechPitch;
        utterance.volume = 1.0;

        // Use a Brazilian Portuguese voice if available
        const voices = this.speechSynthesis.getVoices();
        const ptBRVoice = voices.find(voice =>
            voice.lang.startsWith('pt-BR') || voice.lang.startsWith('pt')
        );
        if (ptBRVoice) {
            utterance.voice = ptBRVoice;
        }

        this.currentUtterance = utterance;
        this.speechSynthesis.speak(utterance);
    }

    setupEventListeners() {
        // Update voices when they become available
        if (this.speechSynthesis) {
            if (this.speechSynthesis.onvoiceschanged !== undefined) {
                this.speechSynthesis.onvoiceschanged = () => {
                    // Vozes carregadas
                };
            }
        }

        // Watch the DOM for new images (site-wide)
        this.setupImageObserver();
    }

    setupImageObserver() {
        // Remove the previous observer, if any
        if (this.imageObserver) {
            this.imageObserver.disconnect();
            this.imageObserver = null;
        }

        // Create a new observer for dynamically added images
        if (this.settings.imageDescription && this.imageDescriptionHandler) {
            this.imageObserver = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1) { // Element node
                            if (node.tagName === 'IMG') {
                                this.attachImageListeners(node);
                            }
                            // Check images inside the node
                            const images = node.querySelectorAll?.('img');
                            if (images) {
                                images.forEach(img => {
                                    this.attachImageListeners(img);
                                });
                            }
                        }
                    });
                });
            });

            this.imageObserver.observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    }

    attachImageListeners(img) {
        // Remove previous listeners to avoid duplicates
        img.removeEventListener('mouseenter', this.imageDescriptionHandler);
        img.removeEventListener('mouseleave', this.stopSpeechHandler);

        // Adiciona novos listeners
        if (this.settings.imageDescription && this.imageDescriptionHandler) {
            img.addEventListener('mouseenter', this.imageDescriptionHandler);
            img.addEventListener('mouseleave', this.stopSpeechHandler);
        }
    }
}

// Initialize once the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.accessibilityManager = new AccessibilityManager();
});


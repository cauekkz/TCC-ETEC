/**
 * Theme manager - EteConnect
 * Reusable system for switching between light and dark mode
 */

class ThemeManager {
    constructor() {
        this.theme = null;
        this.themeToggle = null;
        this.init();
    }

    init() {
        console.log('ThemeManager: Initializing...');
        this.loadTheme();
        this.createThemeToggle();
        this.applyTheme();
        this.setupEventListeners();
        console.log('ThemeManager: Initialized. Current theme:', this.theme);
    }

    loadTheme() {
        console.log('ThemeManager: Loading theme...');
        
        // 1st: user preference (localStorage)
        const savedTheme = localStorage.getItem('eteconnect-theme');
        console.log('ThemeManager: Theme saved to localStorage:', savedTheme);
        
        if (savedTheme && (savedTheme === 'light' || savedTheme === 'dark')) {
            this.theme = savedTheme;
            console.log('ThemeManager: Using saved theme:', this.theme);
            return;
        }

        // 2nd: browser preference (prefers-color-scheme)
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            this.theme = 'dark';
            console.log('ThemeManager: Using system preference (dark)');
            return;
        }

        // 3rd: default (light mode)
        this.theme = 'light';
        console.log('ThemeManager: Using default theme (light)');
    }

    /**
     * Creates the theme toggle button
     */
    createThemeToggle() {
        console.log('ThemeManager: Creating theme button...');
        
        // Check whether a theme button already exists
        const existingToggle = document.querySelector('.light-dark');
        console.log('ThemeManager: Found existing button:', existingToggle);
        
        if (existingToggle) {
            this.themeToggle = existingToggle;
            console.log('ThemeManager: Using existing button');
            
            // Add the event listener to the existing button
            this.addClickHandler(existingToggle);
            return;
        }

        // If it doesn't exist, create a new one
        this.themeToggle = document.createElement('div');
        this.themeToggle.className = 'light-dark';
        this.themeToggle.innerHTML = `
            <div class="moon p-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16">
                    <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286" />
                </svg>
            </div>
            <div class="sun p-1 d-none">
                <svg xmlns="http://www.w3.org/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                    <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                </svg>
            </div>
        `;

        this.insertThemeToggle();
    }

 
    insertThemeToggle() {
        // If a button already exists, there's no need to insert one
        if (document.querySelector('.light-dark')) {
            return;
        }

        const header = document.querySelector('header');
        if (!header) {
            // If there's no header, temporarily insert it into the body
            document.body.appendChild(this.themeToggle);
            return;
        }

        // Look for a suitable place to insert the button
        const headerContent = header.querySelector('.container-fluid, .row, .col');
        if (headerContent) {
            // Insert at the end of the header content
            headerContent.appendChild(this.themeToggle);
        } else {
            // Insert into the header
            header.appendChild(this.themeToggle);
        }
    }

    /**
     * Applies the current theme to the document
     */
    applyTheme() {
        console.log('ThemeManager: Applying theme:', this.theme);
        
        const html = document.documentElement;
        
        // Remove classes anteriores
        html.removeAttribute('data-theme');
        
        // Apply the current theme
        if (this.theme === 'dark') {
            html.setAttribute('data-theme', 'dark');
            console.log('ThemeManager: Dark theme applied');
        } else {
            console.log('ThemeManager: Light theme applied');
        }
        
        // Save to localStorage
        localStorage.setItem('eteconnect-theme', this.theme);
        console.log('ThemeManager: Theme saved to localStorage');
        
        // Update the button
        this.updateToggleButton();
    }

    /**
     * Updates how the toggle button looks
     */
    updateToggleButton() {
        if (!this.themeToggle) return;
        
        const iconSun = this.themeToggle.querySelector('.sun');
        const iconMoon = this.themeToggle.querySelector('.moon');
        
        if (!iconSun || !iconMoon) return;
        
        if (this.theme === 'dark') {
            iconSun.classList.remove('d-none');
            iconMoon.classList.add('d-none');
        } else {
            iconSun.classList.add('d-none');
            iconMoon.classList.remove('d-none');
        }
    }

    /**
     * Toggles between themes
     */
    toggleTheme() {
        console.log('ThemeManager: Switching theme from', this.theme, 'para', this.theme === 'light' ? 'dark' : 'light');
        
        this.theme = this.theme === 'light' ? 'dark' : 'light';
        this.applyTheme();
        
        // Dispatch a custom event for other components
        this.dispatchThemeChangeEvent();
    }

    /**
     * Sets a specific theme
     */
    setTheme(theme) {
        if (theme !== 'light' && theme !== 'dark') {
            console.warn('Invalid theme:', theme);
            return;
        }
        
        this.theme = theme;
        this.applyTheme();
        this.dispatchThemeChangeEvent();
    }

    /**
     * Gets the current theme
     */
    getCurrentTheme() {
        return this.theme;
    }

    /**
     * Dispatches the theme change event
     */
    dispatchThemeChangeEvent() {
        const event = new CustomEvent('themeChanged', {
            detail: { theme: this.theme }
        });
        document.dispatchEvent(event);
    }

    /**
     * Adds the click event listener to the theme button
     */
    addClickHandler(element) {
        console.log('ThemeManager: Adding event listener to element:', element);
        console.log('ThemeManager: HTML element:', element.outerHTML);
        
        // Remove previous event listeners to avoid duplicates
        const newElement = element.cloneNode(true);
        element.parentNode.replaceChild(newElement, element);
        this.themeToggle = newElement;
        
        newElement.addEventListener('click', (e) => {
            console.log('ThemeManager: Theme button clicked!');
            console.log('ThemeManager: Event:', e);
            e.preventDefault();
            e.stopPropagation();
            this.toggleTheme();
        });
        
        console.log('ThemeManager: Event listener added');
    }

    /**
     * Sets up the event listeners
     */
    setupEventListeners() {
        // Theme toggle button (already set up in addClickHandler)
        console.log('ThemeManager: Setting up event listeners...');

        // Listener for changes in the system preference
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', (e) => {
                // Only apply it if the user has no saved preference
                if (!localStorage.getItem('eteconnect-theme')) {
                    this.theme = e.matches ? 'dark' : 'light';
                    this.applyTheme();
                }
            });
        }

        // Listener for theme change events
        document.addEventListener('themeChanged', (e) => {
            // Lets other components react to theme changes
            console.log('Theme changed to:', e.detail.theme);
        });
    }

    /**
     * Forces the theme to be reapplied (useful for dynamic components)
     */
    refresh() {
        this.applyTheme();
    }
}

// Initialize the manager once the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOMContentLoaded fired - creating ThemeManager...');
    window.themeManager = new ThemeManager();
    console.log('ThemeManager created and available at window.themeManager:', window.themeManager);
});
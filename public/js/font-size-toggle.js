/**
 * Font Size Toggle System
 * Persists user preference in localStorage
 */

(function() {
    'use strict';

    // Font size modes
    const FONT_SIZES = {
        normal: 'fs-normal',
        large: 'fs-large',
        default: 'fs-large',
        xlarge: 'fs-xlarge'
    };

    // Storage key
    const STORAGE_KEY = 'labeltech_font_size';

    /**
     * Initialize font size toggle
     */
    function initFontSizeToggle() {
        // Get saved preference or use default
        const savedSize = localStorage.getItem(STORAGE_KEY) || FONT_SIZES.default;
        
        // Apply saved size
        applyFontSize(savedSize);
        
        // Create toggle UI
        createToggleUI();
    }

    /**
     * Apply font size class to html element
     */
    function applyFontSize(size) {
        const html = document.documentElement;
        
        // Remove all font size classes
        Object.values(FONT_SIZES).forEach(fs => {
            html.classList.remove(fs);
        });
        
        // Add selected class
        html.classList.add(size);
        
        // Save to localStorage
        localStorage.setItem(STORAGE_KEY, size);
        
        // Update active button
        updateActiveButton(size);
    }

    /**
     * Create toggle UI buttons
     */
    function createToggleUI() {
        // Check if toggle already exists
        if (document.getElementById('font-size-toggle')) {
            return;
        }

        // Find the top-nav element
        const topNav = document.querySelector('.top-nav');
        if (!topNav) {
            // Fallback: append to body if top-nav not found
            const toggle = createToggleElement();
            document.body.appendChild(toggle);
            return;
        }

        // Create toggle element
        const toggle = createToggleElement();
        
        // Append to top-nav (header)
        topNav.appendChild(toggle);
    }

    /**
     * Create toggle element with buttons
     */
    function createToggleElement() {
        const toggle = document.createElement('div');
        toggle.id = 'font-size-toggle';
        toggle.className = 'font-size-toggle';
        toggle.setAttribute('role', 'group');
        toggle.setAttribute('aria-label', 'تغيير حجم الخط');

        const currentSize = localStorage.getItem(STORAGE_KEY) || FONT_SIZES.default;

        // Create buttons for each size
        const sizes = [
            { key: FONT_SIZES.normal, label: 'عادي', ariaLabel: 'حجم خط عادي' },
            { key: FONT_SIZES.large, label: 'كبير', ariaLabel: 'حجم خط كبير (افتراضي)' },
            { key: FONT_SIZES.xlarge, label: 'كبير جداً', ariaLabel: 'حجم خط كبير جداً' }
        ];

        sizes.forEach(size => {
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = size.label;
            button.setAttribute('aria-label', size.ariaLabel);
            button.setAttribute('data-size', size.key);
            
            if (size.key === currentSize) {
                button.classList.add('active');
            }

            button.addEventListener('click', function() {
                applyFontSize(size.key);
            });

            toggle.appendChild(button);
        });

        return toggle;
    }

    /**
     * Update active button state
     */
    function updateActiveButton(size) {
        const buttons = document.querySelectorAll('#font-size-toggle button');
        buttons.forEach(btn => {
            if (btn.getAttribute('data-size') === size) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    /**
     * Initialize on DOM ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFontSizeToggle);
    } else {
        initFontSizeToggle();
    }

    // Export for manual use if needed
    window.FontSizeToggle = {
        setSize: applyFontSize,
        getCurrentSize: function() {
            return localStorage.getItem(STORAGE_KEY) || FONT_SIZES.default;
        }
    };

})();



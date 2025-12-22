/**
 * Font Size Toggle System
 * Persists user preference in localStorage
 */

(function () {
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

        // Initialize buttons if they exist
        initToggleButtons();
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
     * Initialize toggle buttons (if they exist in HTML)
     */
    function initToggleButtons() {
        const toggle = document.getElementById('font-size-toggle');
        if (!toggle) {
            return;
        }

        const buttons = toggle.querySelectorAll('button[data-size]');
        const currentSize = localStorage.getItem(STORAGE_KEY) || FONT_SIZES.default;

        buttons.forEach(button => {
            const size = button.getAttribute('data-size');

            // Set active state
            if (size === currentSize) {
                button.classList.add('active');
            }

            // Add click event listener
            button.addEventListener('click', function () {
                applyFontSize(size);
            });
        });
    }

    /**
     * Update active button state
     */
    function updateActiveButton(size) {
        const buttons = document.querySelectorAll('#font-size-toggle button[data-size]');
        buttons.forEach(btn => {
            const btnSize = btn.getAttribute('data-size');
            if (btnSize === size) {
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
        getCurrentSize: function () {
            return localStorage.getItem(STORAGE_KEY) || FONT_SIZES.default;
        }
    };

})();

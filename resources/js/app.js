import './bootstrap';

// Fonts
import '@fontsource/plus-jakarta-sans/400.css';
import '@fontsource/plus-jakarta-sans/500.css';
import '@fontsource/plus-jakarta-sans/600.css';
import '@fontsource/plus-jakarta-sans/700.css';
import '@fontsource/plus-jakarta-sans/800.css';

// Animate.css
import 'animate.css';

// Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// iOS Safari fix: forces click events to bubble on all elements so that
// Alpine's @click.away directive works correctly on touchscreen devices.
document.addEventListener('touchstart', function () {}, { passive: true });

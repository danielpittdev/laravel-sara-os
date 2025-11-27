import './bootstrap';
import '@tailwindplus/elements';
import $ from 'jquery';

import FormBackendValidation from 'form-backend-validation';

// opción: si quieres exponerlo globalmente en window
window.FormBackendValidation = FormBackendValidation;
window.$ = window.jQuery = $;
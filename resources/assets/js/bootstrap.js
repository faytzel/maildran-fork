
window._ = require('lodash');

/**
 * We'll load jQuery
 */

window.$ = window.jQuery = require('jquery');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.timeout                            = 10000;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

/**
 * alert
 */
window.toastr = require('toastr');
window.swal   = require('sweetalert2');

/**
 * mailcheck
 */
require('mailcheck');

/**
 * clipboard
 */
window.Clipboard = require('clipboard');

/**
 * i18n
 */
window.i18next    = require('i18next');
window.i18nextXhr = require('i18next-xhr-backend');
window.is         = require('is_js');

// lang resources
require('./../../../resources/lang/es/javascript.js');

/**
 * Cookie Consent
 */
require('cookieconsent');

/**
 * Polyfill for date input
 */
window.flatpickr        = require('flatpickr');
window.flatpickrSpanish = require('flatpickr/dist/l10n/es.js').es;

/**
 * Custom classes
 */
require('./classes/Exception');
require('./classes/Ajax');
require('./classes/Form');
require('./classes/Navigator');
require('./classes/Message');
require('./classes/Modal');
require('./classes/Router');
require('./classes/Mail');
require('./classes/Url');
require('./classes/Miscellaneous');
require('./classes/CookieConsent');
require('./classes/Menu');
require('./classes/Reminder');
require('./classes/Clipboard');
require('./classes/Date');
require('./classes/Settings');

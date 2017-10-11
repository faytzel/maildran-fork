
/**
 * First we will load all of this project's JavaScript dependencies which
 * It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Custom class
 */
window.App = {
    Exception    : new ExceptionClass(),
    Ajax         : new AjaxClass(),
    Form         : new FormClass(),
    Navigator    : new NavigatorClass(),
    Message      : new MessageClass(),
    Modal        : new ModalClass(),
    Router       : new RouterClass(),
    Mail         : new MailClass(),
    Url          : new UrlClass(),
    Miscellaneous: new MiscellaneousClass(),
    CookieConsent: new CookieConsentClass(),
    Menu         : new MenuClass(),
    Reminder     : new ReminderClass(),
    Clipboard    : new ClipboardClass(),
    Date         : new DateClass(),
    Settings     : new SettingsClass()
};

/**
 * i18n
 */

// no uso la opcion "backend" para la carga de lenguaje por ajax
// porque a veces tarda demasiado en cargar y no muestra las traduciones de js
window.App.Lang = i18next.use(i18nextXhr).init({
    lng        : $('html').attr('lang'),
    fallbackLng: 'en',
    resources  : {
        es: {
            translation: window.LangResourceEs
        }
    }
});

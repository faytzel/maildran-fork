class CookieConsent
{
    constructor()
    {
        let self = this;

        $(document).ready(function()
        {
            self.show();
        });
    }

    show()
    {
        window.cookieconsent.initialise({
            palette: {
                popup: {
                    background: '#000000',
                    text      : '#FFFFFF'
                },
                button: {
                    background: '#FFFFFF',
                    color     : '#000000'
                }
            },
            type: 'opt-in',
            position: 'bottom-right',
            content: {
                message: App.Lang.t('cookieConsent.msg1'),
                dismiss: '',
                allow  : App.Lang.t('cookieConsent.msg2'),
                link   : App.Lang.t('cookieConsent.msg3'),
                href   : App.Router.url('legal.cookie')
            },
            blacklistPage: [
                /legal\/([a-z\-]+)$/
            ],
            onPopupOpen: function () {
                var self = this;

                // si aun no esta aceptada la politica de cookies
                if (!self.hasConsented()) {
                    // aceptamos automaticamente al navegar por la web
                    $('a').not('[href=""]').not('[href="#"]').on('click', function() {
                        var url = $(this).attr('href');

                        // no aceptamos automaticamente las cookies cuando navegas a:
                        // otras webs o a las paginas legales (tos, privacy, cookies)
                        if (App.Url.sameHost(url) && !url.match(/legal\/([a-z\-]+)$/)) {
                            self.setStatus(cookieconsent.status.allow);
                            self.close(true);
                        }
                    });
                }
            }
        });
    }
}

export default CookieConsent;
window.CookieConsentClass = CookieConsent;

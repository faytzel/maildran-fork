class Mail
{
    constructor()
    {
        //
    }

    check(emailField)
    {
        let emailFormGroup = $(emailField).closest('.form-group');
        let emailSuggest   = emailFormGroup.find('.mailcheck');

        // solo una extension de dominio por dominio que este en "secondLevelDomains"
        // ya que "secondLevelDomains" usa las extensiones de "topLevelDomains"
        let domains = ['icloud.com', 'msn.com', 'gmail.com', 'googlemail.com', 'hotmail.com', 'live.com', 'outlook.com', 'yahoo.com', 'aol.com'];
        let secondLevelDomains = ['gmail', 'outlook', 'hotmail', 'live', 'yahoo'];
        let topLevelDomains = ['com', 'net', 'org', 'es', 'com.mx', 'com.ar'];

        $(emailField).mailcheck({
            domains: domains,
            secondLevelDomains: secondLevelDomains,
            topLevelDomains: topLevelDomains,
            suggested: function(item, suggestion) {
                // remove old suggest
                if (emailSuggest.length == 1) {
                    emailSuggest.remove();
                }

                emailFormGroup.append(
                    '<span class="mailcheck">' +
                        App.Lang.t('mailcheckQuestion') +
                        ' <a href="#" title="" onclick="App.Mail.checkSetSuggest(this); return false;"' +
                            'class="mailcheck-email">' + suggestion.address + '@<span class="mailcheck-domain">' + suggestion.domain + '</span></a>?' +
                    '</span>'
                );
            },
            empty: function(item) {
                // remove suggest
                if (emailSuggest.length == 1) {
                    emailSuggest.remove();
                }
            }
        });
    }

    checkSetSuggest(emailFixed)
    {
        let emailFormGroup = $(emailFixed).closest('.form-group');

        // put email suggest in field
        let email = $(emailFixed).text();
        emailFormGroup.find('input[type="email"]').val(email);

        // remove suggest
        emailFormGroup.find('.mailcheck').remove();
    }
}

export default Mail;
window.MailClass = Mail;

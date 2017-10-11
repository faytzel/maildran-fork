class Settings
{
    constructor()
    {
        //
    }

    userDelete(formButton)
    {
        let form   = $(formButton).closest('form');
        let url    = form.attr('action') + '?' + form.serialize();
        let method = _.toLower(form.attr('method'));

        App.Modal.confirmSendForm(
            App.Lang.t('settings.user.delete.title'),
            App.Lang.t('settings.user.delete.description'),
            url,
            method
        );
    }
}

export default Settings;
window.SettingsClass = Settings;

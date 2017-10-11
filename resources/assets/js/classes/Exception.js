class Exception
{
    constructor()
    {
        //
    }

    ajax(error)
    {
        /*
         * NOTA: App.Modal.loquesea() debe ir con setTimeout() para evitar problemas con App.Form.modalConfirmHide()
         * Ocurre que el modal de App.Exception.ajax() no aparece despues de ocultar el modal de confirmacion (al borrar algo por ejemplo)
        */
        if (error.response) {
            switch (error.response.status) {
                // authentication
                case 401:
                    setTimeout(function() {
                        App.Modal.confirm(
                            App.Lang.t('message.error.401.title'),
                            App.Lang.t('message.error.401.description'),
                            function() {
                                let data = error.response.data;

                                if (typeof data == 'object' && data.hasOwnProperty('url')) {
                                    App.Navigator.go(data.url);
                                } else {
                                    App.Navigator.reload();
                                }
                            }
                        );
                    }, 0);
                    break;
                // policies
                case 403:
                    setTimeout(function() {
                        App.Modal.alert(
                            App.Lang.t('message.error.403.title'),
                            App.Lang.t('message.error.403.description')
                        );
                    }, 0);
                    break;
                // not found
                case 404:
                    App.Navigator.redirect(error.response.request.responseURL);
                    break;
                // csrf
                case 412:
                    setTimeout(function() {
                        App.Modal.confirm(
                            App.Lang.t('message.error.412.title'),
                            App.Lang.t('message.error.412.description'),
                            function() {
                                App.Navigator.reload();
                            }
                        );
                    }, 0);
                    break;
                // validation
                case 422:
                    if (typeof error.response.data == 'object') {
                        App.Message.warning(App.Message.jsonToHtml(error.response.data));
                        break;
                    }
                    // si no entra al "if", va al "default"
                case 423:
                    if (typeof error.response.data == 'object') {
                        App.Message.error(App.Message.jsonToHtml(error.response.data));
                        break;
                    }
                    // si no entra al "if", va al "default"
                // maintenance
                case 503:
                    setTimeout(function() {
                        App.Modal.alert(
                            App.Lang.t('message.error.503.title'),
                            App.Lang.t('message.error.503.description'),
                            App.Modal.TYPE_INFO
                        );
                    }, 0);
                    break;
                case 500:
                    this.generic(error);
                    if (error.response.config.method == 'get') {
                        App.Navigator.redirect(error.response.request.responseURL);
                    }
                    break;
                // generic
                default:
                    this.generic(error);
            }
        } else {
            this.generic(error);
        }
    }

    generic(error)
    {
        App.Message.error(App.Lang.t('message.error.500.text'));
        console.log('Exception.generic -> ' + error);
    }
}

export default Exception;
window.ExceptionClass = Exception;

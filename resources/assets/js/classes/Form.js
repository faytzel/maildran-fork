class Form
{
    constructor()
    {
        let self = this;

        self.submitTextOld = null;
        self.swalResolve   = null;

        // form submit
        $('body').on('submit', 'form', function(event) {
            let form = $(this);

            if (form.find('.g-recaptcha').length > 0) {
                // reset and show captcha
                grecaptcha.reset();
                grecaptcha.execute();
            } else {
                self.sendForm(form);
            }

            event.preventDefault();
        });
    }

    sendForm(form)
    {
        let url    = form.attr('action');
        let method = _.toLower(form.attr('method'));

        // get form data
        let data = {};
        $.each(form.serializeArray(), function(i, field) {
            data[field.name] = field.value;
        });

        this.send(url, data, form, method);
    }

    send(url, data = {}, form = null, method = 'post')
    {
        let self     = this;
        let formData = {};
        let urlData  = {};

        self.lock(form);

        // method DELETE using "url params"
        if (method === 'delete') {
            urlData = data;
        // other methods using "form data"
        } else {
            formData = data;
        }

        axios.request({
            url    : url,
            method : method,
            data   : formData,
            params : urlData,
            headers: {
                // el CSRF Token puede cambiar en cualquier peticion GET al navegar por AJAX
                // por lo que no puede estar en el header global de axios
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
        })
        .then(function (response) {
            if (is.json(response.data)) {
                let json = response.data;

                // LA LOGICA ESTA EN EL CODIGO DEL SERVIDOR //

                // show message
                if (!_.isNull(json.message)) {
                    App.Message.showByJson(json.message);
                }
                // reload
                if (json.reload) {
                    App.Navigator.refresh();
                }
                // redirect
                if (!_.isNull(json.redirect)) {
                    App.Navigator.go(json.redirect);
                }
                // clear form
                if (json.clear) {
                    self.clear(form);
                }
            } else {
                let htmlReplaced = App.Ajax.replaceHtml(response, function(title, content, urlNew) {
                    // add to browser history if is new url
                    if (!App.Navigator.urlEqual(App.Navigator.urlCurrent(), urlNew)) {
                        App.Navigator.historyAdd(urlNew, title);
                    }
                });
                if (htmlReplaced) {
                    App.Navigator.scrollTop();
                } else {
                    App.Exception.generic('Ajax response must be html');
                }

                App.Ajax.onLoad();
            }

            self.modalConfirmHide();
            self.unlock(form);
        })
        .catch(function (error) {
            self.modalConfirmHide();
            App.Exception.ajax(error);
            self.unlock(form);
        });
    }

    modalConfirmHide()
    {
        if (!_.isNull(App.Form.swalResolve)) {
            App.Form.swalResolve();
            App.Form.swalResolve = null;
        }
    }

    lock(form)
    {
        if (!_.isNull(form)) {
            let button = form.find('button[type="submit"]');

            if (button.length > 1) {
                throw 'Form - Lock - many submit buttons';
            }

            if (button.length == 1) {
                button.prop('disabled', true);
                self.submitTextOld = button.html();
                button.html('<i class="fa fa-circle-o-notch fa-spin"></i>' + App.Lang.t('sending') + '...');
            }
        }
    }

    unlock(form)
    {
        if (!_.isNull(form)) {
            let button = form.find('button[type="submit"]');

            if (button.length > 1) {
                throw 'Form - Unlock - many submit buttons';
            }

            if (button.length == 1) {
                button.prop('disabled', false);
                button.html(self.submitTextOld);
                self.submitTextOld = null;
            }
        }
    }

    clear(form)
    {
        let formId = form.attr('id');

        document.getElementById(formId).reset();
    }
}

export default Form;
window.FormClass = Form;

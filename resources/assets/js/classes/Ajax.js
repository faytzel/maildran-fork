class Ajax
{
    constructor()
    {
        //
    }

    onLoad()
    {
        App.Message.onLoad();
    }

    replaceHtml(response, callback = null)
    {
        // si no es un string, devolvemos false
        if (!_.isString(response.data)) {
            return false;
        }

        // get html object
        let htmlDom = document.createElement('html');
        htmlDom.innerHTML = response.data;
        let htmlParsed = $(htmlDom);

        // si no encontramos los elementos en el html, devolvemos false
        if (htmlParsed.find('head > title').length == 0 || htmlParsed.find('#app').length == 0) {
            return false;
        }

        // get data from html
        let title   = htmlParsed.find('head > title').text();
        let content = htmlParsed.find('#app').html();
        let urlNew  = response.request.responseURL;

        // set new html content
        $('#app').html(content);

        // set new title
        App.Navigator.title(title);

        // datetime
        App.Date.inputDatetime();
        App.Date.inputTime();

        // autofocus
        if ($('body').find('[autofocus]').length == 1) {
            $('body').find('[autofocus]').focus();
        }

        if (!_.isNull(callback)) {
            callback(title, content, urlNew);
        }

        return true;
    }

    loaderShow()
    {
        $('#header-loader').removeClass('hidden');
    }

    loaderHide()
    {
        $('#header-loader').addClass('hidden');
    }
}

export default Ajax;
window.AjaxClass = Ajax;

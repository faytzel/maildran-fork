class Navigator
{
    constructor()
    {
        let self = this;

        self.titleOld           = null;
        self.titleLoadingActive = false;

        // history browser manager
        window.onpopstate = function(event) {
            // event.state is null when hash change
            if (!_.isNull(event.state)) {
                self.go(self.urlCurrent(), false);
            }
        };

        // navigation
        if (window.Laravel.navigatorAjax) {
            $('body').on('click', 'a', function(event) {
                if (_.isUndefined($(this).attr('target'))) {
                    let url = _.trim($(this).attr('href'));
                    if (_.isEmpty(url) || url == '#') {
                        event.preventDefault();
                    } else if (App.Url.sameHost(url)) {
                        self.go(url);
                        event.preventDefault();
                    }
                }
            });
        }
    }

    go(url, addHistory = true)
    {
        let self = this;

        App.Ajax.loaderShow();
        App.Navigator.titleLoading();

        axios.get(url, {
            responseType: 'text'
        })
        .then(function (response) {
            // redirect if is new app version
            if (response.headers.hasOwnProperty('x-app-version')
                && window.Laravel.version != response.headers['x-app-version']) {
                self.redirect(response.request.responseURL);
            // else, replace new html
            } else {
                let htmlReplaced = App.Ajax.replaceHtml(response, function(title, content, urlNew) {
                    // add to browser history
                    if (addHistory) {
                        self.historyAdd(urlNew, title);
                    }

                    // sent to GA
                    if (!_.isUndefined(window.ga) && !_.isNull(window.ga)) {
                        ga('set', {page: urlNew, title: title});
                        ga('send', 'pageview');
                    }
                });
                if (htmlReplaced) {
                    App.Ajax.onLoad();
                    App.Ajax.loaderHide();
                    self.scrollTop();
                } else {
                    self.redirect(url);
                }
            }
        })
        .catch(function (error) {
            App.Exception.ajax(error);
            App.Ajax.loaderHide();
            App.Navigator.titleRestore();
        });
    }

    title(text)
    {
        if (!this.titleLoadingActive) {
            this.titleOld = window.document.title;
        }

        window.document.title   = text;
        this.titleLoadingActive = false;
    }

    titleLoading()
    {
        this.titleOld           = window.document.title;
        window.document.title   = App.Lang.t('loading') + '...';
        this.titleLoadingActive = true;
    }

    titleRestore()
    {
        if (!_.isNull(this.titleOld)) {
            window.document.title   = this.titleOld;
            this.titleOld           = null;
            this.titleLoadingActive = false;
        }
    }

    refresh()
    {
        this.go(this.urlCurrent(), false);
    }

    reload()
    {
        // el parametro "true" evita que haya cache (firefox)
        window.location.reload(true);
    }

    urlCurrent()
    {
        return window.location.href;
    }

    redirect(url)
    {
        if (!this.urlEqual(this.urlCurrent(), url)) {
            window.location.href = url;
        } else {
            this.reload();
        }
    }

    historyAdd(url, title)
    {
        history.pushState({}, title, url);
    }

    urlEqual(url, urlCompare)
    {
        // hay que tener en cuenta de que un window.location.href = window.location.href con una url igual a la actual y con hash, no recarga la web
        // y para eso recargamos la web
        let urlParsed        = url.split('#')[0];
        let urlCompareParsed = urlCompare.split('#')[0];

        // remove last slash
        urlParsed        = urlParsed.replace(/\/$/g, '');
        urlCompareParsed = urlCompareParsed.replace(/\/$/g, '');

        if (urlParsed == urlCompareParsed) {
            return true;
        }

        return false;
    }

    scrollTop()
    {
        $(window).scrollTop(0);
    }
}

export default Navigator;
window.NavigatorClass = Navigator;

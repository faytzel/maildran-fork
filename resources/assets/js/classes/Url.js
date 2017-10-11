class Url
{
    constructor()
    {
        //
    }

    sameHost(url)
    {
        let regex = new RegExp('^(http(s)?:)?\/\/' + App.Miscellaneous.escapeRegExp(window.location.hostname));
        if (!_.isEmpty(url) && url.match(regex)) {
            return true;
        }
        return false;
    }
}

export default Url;
window.UrlClass = Url;

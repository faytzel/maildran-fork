class Router
{
    constructor()
    {
        //
    }

    baseUrl()
    {
        return $('head > base').attr('href');
    }

    url(name)
    {
        return window.Laravel.routes[name];
    }
}

export default Router;
window.RouterClass = Router;

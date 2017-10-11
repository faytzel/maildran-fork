class Miscellaneous
{
    constructor()
    {
        //
    }

    escapeRegExp(text)
    {
        return text.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&');
    }
}

export default Miscellaneous;
window.MiscellaneousClass = Miscellaneous;

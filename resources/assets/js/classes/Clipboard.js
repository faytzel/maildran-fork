class Clipboard
{
    constructor()
    {
        let self = this;

        $(document).ready(function()
        {
            self.onLoad();
        });
    }

    onLoad()
    {
        var clipboard = new window.Clipboard('.btn-clipboard');

        clipboard.on('success', function(e) {
            App.Message.success(App.Lang.t('message.success.clipboard'));
            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            App.Message.error(App.Lang.t('message.error.clipboard'));
        });
    }
}

export default Clipboard;
window.ClipboardClass = Clipboard;

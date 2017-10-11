class Message
{
    constructor()
    {
        var self = this;

        toastr.options.escapeHtml    = false;
        toastr.options.progressBar   = true;
        toastr.options.closeDuration = 200;

        $(document).ready(function() {
            self.onLoad();
        });
    }

    onLoad()
    {
        message_on_load();
    }

    success(text)
    {
        toastr.success(text);
    }

    warning(text)
    {
        toastr.warning(text);
    }

    error(text)
    {
        toastr.error(text);
    }

    showByJson(message)
    {
        if (message.type == 'success') {
            this.success(message.text);
        } else if (message.type == 'error') {
            this.error(message.text);
        } else {
            throw 'Message - showByJson - message type invalid';
        }
    }

    jsonToHtml(validations)
    {
        let html = '<ul>';
        _.forEach(validations, function(messages, field) {
            if (_.isString(messages)) {
                html = html + '<li>' + messages + '</li>';
            } else {
                _.forEach(messages, function(message, key) {
                    html = html + '<li>' + message + '</li>';
                });
            }
        });
        html = html + '</ul>';

        return html;
    }
}

export default Message;
window.MessageClass = Message;

class Modal
{
    constructor()
    {
        this.TYPE_SUCCESS  = 'success';
        this.TYPE_QUESTION = 'question';
        this.TYPE_INFO     = 'info';
        this.TYPE_WARNING  = 'warning';
        this.TYPE_ERROR    = 'error';
    }

    confirm(title, text, callback)
    {
        swal.close();

        swal({
            title: title,
            text: text,
            type: this.TYPE_QUESTION,
            showCancelButton: true,
            confirmButtonText: App.Lang.t('modal.confirm.buttonConfirm'),
            cancelButtonText: App.Lang.t('modal.confirm.buttonCancel')
        }).then(function() {
            callback();
        }, function (dismiss) {
            // dismiss can be 'cancel', 'overlay', 'close', and 'timer'
        });
    }

    confirmSendForm(title, text, url, method = 'post')
    {
        swal.close();

        swal({
            title: title,
            text: text,
            type: this.TYPE_QUESTION,
            showCancelButton: true,
            confirmButtonText: App.Lang.t('modal.confirm.buttonConfirm'),
            cancelButtonText: App.Lang.t('modal.confirm.buttonCancel'),
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    App.Form.swalResolve = resolve;
                    App.Form.send(url, {}, null, method);
                })
            }
        }).catch(swal.noop);
    }

    alert(title, text, type = this.TYPE_ERROR)
    {
        swal.close();

        swal({
            title: title,
            text: text,
            type: type,
            showCancelButton: false,
            confirmButtonText: App.Lang.t('modal.alert.buttonConfirm')
        });
    }
}

export default Modal;
window.ModalClass = Modal;

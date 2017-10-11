class Reminder
{
    constructor()
    {
        //
    }

    delete(url)
    {
        App.Modal.confirmSendForm(
            App.Lang.t('reminder.delete.title'),
            App.Lang.t('reminder.delete.description'),
            url,
            'delete'
        );
    }
}

export default Reminder;
window.ReminderClass = Reminder;

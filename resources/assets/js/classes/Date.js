class Date
{
    constructor()
    {
        let self = this;

        $(document).ready(function()
        {
            self.inputDatetime();
            self.inputTime();
        });
    }

    inputTime()
    {
        $('.input-time').flatpickr({
            enableTime: true,
            noCalendar: true,
            time_24hr : true,
            dateFormat: 'H:i',
            locale    : window.flatpickrSpanish
        });
    }

    inputDatetime()
    {
        $('.input-datetime').flatpickr({
            altFormat : 'd-m-Y H:i',
            dateFormat: 'Y-m-dTH:i',
            altInput  : true,
            enableTime: true,
            time_24hr : true,
            locale    : window.flatpickrSpanish
        });
    }
}

export default Date;
window.DateClass = Date;

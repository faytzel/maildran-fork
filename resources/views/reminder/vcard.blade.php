BEGIN:VCARD
VERSION:3.0
N:Reminder;{{ Config::get('app.name') }};;;
FN:{{ Config::get('app.name') }} Reminder
EMAIL;type=INTERNET;type=pref:{{ $emailReminder }}
item1.URL;type=pref:https://{{ Config::get('app.domains.web') }}
END:VCARD

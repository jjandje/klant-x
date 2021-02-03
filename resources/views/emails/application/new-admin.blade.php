@component('mail::message')
# Beste,

Er is zojuist een nieuwe aanvraag binnengekomen namens het bedrijf: {{ $application->companyname }}.

Hieronder vind je verdere informatie voor deze aanvraag:

@component('mail::panel')
- Naam: {{ $application->name }}
- Bedrijfsnaam: {{ $application->companyname }}
- Telefoonnummer: {{ $application->phonenumber }}
- Emailadres: {{ $application->emailaddress }}
- Pakket: {{ $application->package }}
- Bericht: {{ $application->message }}
@endcomponent

Klik op de onderstaande button om direct naar deze nieuwe aanvraag te gaan:

@component('mail::button', ['url' => route('application.edit', ['id' => $application->id] ) ])
    Aanvraag bekijken
@endcomponent

Met vriendelijke groet,<br>
{{ config('app.name') }}
@endcomponent

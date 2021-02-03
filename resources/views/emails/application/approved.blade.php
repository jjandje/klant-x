@component('mail::message')
# Aanvraag voor {{ $company->name }} goedgekeurd!

Dag {{ $user->name }},

We hebben je aanvraag voor {{ $company->name }} zojuist goedgekeurd.

Je kunt inloggen via de onderstaande button en je wachtwoord instellen.

@component('mail::button', ['url' => route('backpack.auth.password.reset.token', ['token' => $token, 'email' => $user->email])])
Inloggen
@endcomponent

Met vriendelijke groet,<br>
{{ config('app.name') }}
@endcomponent

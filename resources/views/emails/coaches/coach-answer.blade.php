@component('mail::message')

# Hi,

Je coach "{{ $coach->name }}" heeft je een bericht gestuurd.
Dit is wat {{ $coach->name }} je heeft gestuurd:

<i>{{ $onderwerp }},</i>

<i>{{ $message }}</i>

Met vriendelijke groet,<br>
Het team van {{ config('app.name') }}
@endcomponent

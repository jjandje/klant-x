@component('mail::message')

# Beste,

{{ $user->name }} heeft een vraag voor de {{ count($coaches) > 1 ? 'coaches' : 'coach' }}

De {{ count($coaches) > 1 ? 'coaches zijn' : 'coach is' }}:
@foreach($coaches as $coach)
- {{ $coach->name }} (Email: {{ $coach->email }})
@endforeach

De vraag van {{ $user->name }},

Onderwerp: {{ ucfirst( implode( ' ', explode('-', $onderwerp ) ) ) }}<br/>
Bericht: {{ $message }}

Met vriendelijke groet,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# Hi!

Dit is gegarandeerd je leukste mail deze week! Je bent namelijk aangemeld voor het platform van Healthyby!

Healthyby is een nieuw platform waar gezondheid centraal staat. Je vind hier veel gezonde recepten en informatieve blogs, welke aangevuld worden door onze online coaches. Je kunt zelfs aan de slag met je eigen gezonde doelen, inclusief je eigen online coach!

Dit alles kun je doen en vinden binnen je persoonlijke en veilige online omgeving. Je ontdekt het platform door je te registeren via onderstaande button. Veel plezier!

@component('mail::button', ['url' => route('backpack.auth.password.reset.token', ['token' => $token, 'email' => $user->email])])
    Registreren
@endcomponent

Met vriendelijke groet,<br>
Het team van {{ config('app.name') }}
@endcomponent

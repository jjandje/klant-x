<?php

return [
	'required'  => [
		'title'         => 'Het titel veld is een verplicht veld',
		'image'         => 'Het is verplicht om een afbeelding toe te voegen',
		'content'       => 'Het content veld is een verplicht veld',
		'goal_id'       => 'Het is verplicht om een doel toe te voegen',
		'goals'         => 'Het is verplicht om een of meerdere doelen toe te voegen',
		'email'         => 'Het is verplicht om een emailadres toe te voegen',
		'emails'        => 'Het is verplicht om emails toe te voegen',
		'preparation'   => 'Het bereiding veld is een verplicht veld',
		'ingredients'   => 'Het is verplicht om ingrediënten toe te voegen',
		'duration'      => 'De duur van het doel is een verplicht veld',
		'articles'      => 'Het is verplicht om blog(s) toe te voegen',
		'recipes'       => 'Het is verplicht om een recept / recepten toe te voegen',
		'age'           => 'Voer uw leeftijd in',
		'gender'        => 'Selecteer uw geslacht',
		'length'        => 'Voer uw lengte in in cm',
		'weight'        => 'Voer uw gewicht in in kg',
		'coach_ids'     => 'Er is geen coach geselecteerd',
		'subject'       => 'Er is geen onderwerp gekozen',
		'message'       => 'Er is geen vraag ingevoerd',
		'user_id'       => 'Er is wat mis gegaan. Ververs de pagina en probeer het opnieuw',
		'name'          => 'Het is verplicht om een naam in te vullen',
		'company_name'  => 'Het is verplicht om een bedrijfsnaam in te vullen',
		'phonenumber'   => 'Het is verplicht om een telefoonnummer in te vullen',
		'message'       => 'Het bericht mag niet leeg zijn',
	],

	'numeric'   => [
		'age'           => 'De leeftijd dient enkel uit cijfers te bestaan',
		'length'        => 'De lengte dient enkel uit cijfers te bestaan',
		'weight'        => 'Het gewicht dient enkel uit cijfers te bestaan',
		'duration'      => 'De duur van het doel dient enkel uit cijfers te bestaan',
		'phonenumber'   => 'Het telefoonnummer mag alleen nummers bevatten',
	],

	'unique'    => [
		'company_name'  => 'Deze bedrijfsnaam is al in gebruik',
		'email'         => 'Dit emailadres is al in gebruik',
	]
];

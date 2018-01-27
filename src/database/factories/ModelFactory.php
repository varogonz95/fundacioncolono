<?php

/*
|--------------------------------------------------------------------------
| Persona Factory
|--------------------------------------------------------------------------
*/
$factory->define(App\Models\Persona::class, function (Faker\Generator $faker) {

    $tels = "$faker->tollFreephoneNumber";
    $randomNumbers = $faker->numberBetween(0,2);

    for($i = 0; $i < $randomNumbers; $i++){
        $tels .= ", $faker->tollFreephoneNumber";
    }

    return [
        'cedula'=>$faker->randomNumber(9,true),
        'nombre'=>$faker->firstname,
        'apellidos'=>"{$faker->lastname} {$faker->lastname}",
        'ocupacion'=>$faker->jobTitle,
        'telefonos'=>$tels,
        'ubicacion'=>'7/2/1',
        'direccion'=>$faker->address,
        'contactos'=>$faker->text(100)
    ];
});

/*
|--------------------------------------------------------------------------
| Referente Factory
|--------------------------------------------------------------------------
*/
$factory->define(App\Models\Referente::class, function (Faker\Generator $faker) {
	return ['descripcion' => $faker->boolean ? $faker->company : "{$faker->firstName} {$faker->lastname}"];
});


/*
|--------------------------------------------------------------------------
| Expediente Factory
|--------------------------------------------------------------------------
*/
$factory->define(App\Models\Expediente::class, function (Faker\Generator $faker) {
	$hasReferente = $faker->boolean;
	$referentes = App\Models\Referente::all();
	$referente_otro = $referentes[0];
	$referentes_count = count($referentes);

    return [
		'referente_otro' => $hasReferente ? null : ($faker->boolean? $faker->company : "{$faker->firstName} {$faker->lastname}"),
		'referente_fk'	 => $hasReferente ? $referentes[$faker->numberBetween(1, $referentes_count - 1)]->id : $referente_otro->id,
        'descripcion'    => $faker->text(500),
		'persona_fk'     => function(){ return factory(App\Models\Persona::class)->create()->cedula; },
        'prioridad'      => $faker->numberBetween(1,3),
        'estado'         => $faker->numberBetween(0,3),
    ];
});

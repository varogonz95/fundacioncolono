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
    if (App\Models\Referente::count() > 0) {
        return ['descripcion' => $faker->boolean? $faker->company : "{$faker->firstName} {$faker->lastname}"];
    }
    else{
        return [
            'descripcion' => 'Otro',
        ];
    }

});

/*
|--------------------------------------------------------------------------
| Ayuda Factory
|--------------------------------------------------------------------------
*/
$factory->define(App\Models\Ayuda::class, function (Faker\Generator $faker) {

    $first_day = $faker->numberBetween(1, 15);
    $second_day = $faker->numberBetween($first_day + 1, 30);

    return [
        'descripcion' => $faker->text(50),
        'primer_dia_entrega' => $first_day,
        'segundo_dia_entrega' => $second_day,
    ];
});

/*
|--------------------------------------------------------------------------
| Expediente Factory
|--------------------------------------------------------------------------
*/
$factory->define(App\Models\Expediente::class, function (Faker\Generator $faker) {

    $hasReferente = $faker->boolean;

    return [
        'persona_fk' => function(){ return factory(App\Models\Persona::class)->create()->cedula; },
        'referente_fk' => $hasReferente? factory(App\Models\Referente::class)->create()->id : 1,   //  Referente id = 1: 'Otro' option
        'referente_otro' => $hasReferente? null : ($faker->boolean? $faker->company : "{$faker->firstName} {$faker->lastname}"),
        'prioridad' => $faker->numberBetween(1,3),
        'estado' => $faker->numberBetween(0,3),
        'descripcion' => $faker->text(500),
    ];
});

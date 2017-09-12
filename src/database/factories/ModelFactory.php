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
| Expediente Factory
|--------------------------------------------------------------------------
*/
$factory->define(App\Models\Expediente::class, function (Faker\Generator $faker) {

    $hasReferente = $faker->boolean;
    // $approved = $faker->boolean;

    if ($hasReferente) {
        return [
            'persona_fk' => function(){
                return factory(App\Models\Persona::class)->create()->cedula;
            },
            'referente_fk' => function(){
                return factory(App\Models\Referente::class)->create()->id;   //  Referente id = 0: 'Otro' option
            },
            'referente_otro' => !$hasReferente? $faker->boolean? $faker->company : "{$faker->firstName} {$faker->lastname}" : null,
            'prioridad' => $faker->numberBetween(1,3),
            'estado' => $faker->numberBetween(0,2),
            'descripcion' => $faker->text(500),
        ];
    }
    else {
        return [
            'persona_fk' => function(){
                return factory(App\Models\Persona::class)->create()->cedula;
            },
            'referente_fk' => 1,   //  Referente id = 0: 'Otro' option
            'referente_otro' => $faker->boolean? $faker->company : "{$faker->firstName} {$faker->lastname}",
            'prioridad' => $faker->numberBetween(1,3),
            'estado' => $faker->numberBetween(0,2),
            'descripcion' => $faker->text(),
        ];
    }
});

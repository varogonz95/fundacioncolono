<?php

/*
|--------------------------------------------------------------------------
| Persona Factory
|--------------------------------------------------------------------------
*/

$factory->define(App\Model\Persona::class, function (Faker\Generator $faker) {

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
        'tels'=>$tels,
        'ubicacion'=>'7/2/1',
        'direccion'=>$faker->address,
        'contactos'=>$faker->text(100)
    ];
});


/*
|--------------------------------------------------------------------------
| TipoAyuda Factory
|--------------------------------------------------------------------------
*/

$factory->define(App\Model\TipoAyuda::class, function (Faker\Generator $faker) {
    return [
        'descripcion'=>$faker->sentence(3,true)
    ];
});


/*
|--------------------------------------------------------------------------
| Expediente Factory
|--------------------------------------------------------------------------
*/
$factory->define(App\Model\Expediente::class, function (Faker\Generator $faker) {

    $p = App\Model\Persona::all();
    $t = App\Model\TipoAyuda::all();
    $cp = count($p)-1;
    $ct = count($t)-1;

    return [
        'persona_fk' => $p[$faker->numberBetween(0,$cp)]->cedula,
        'tipo_ayuda_fk' => $t[$faker->numberBetween(0,$ct)]->id,
        'prioridad' => $faker->numberBetween(1,3),
        'estado' => $faker->numberBetween(0,3),
        'descripcion' => $faker->text(),
        'recomendaciones' => $faker->text(),
        'fecha_creacion' => $faker->date('Y-m-d', '2025-01-01')." ".$faker->time('H:i:s', '00:00:00'),
        'monto' => $faker->randomNumber(6)
    ];
});

/*
|--------------------------------------------------------------------------
| HistoricoExpediente Factory
|--------------------------------------------------------------------------
*/
$factory->define(App\Model\HistoricoExpediente::class, function (Faker\Generator $faker) {

    $es = App\Model\Expediente::all();
    $ce = count($es)-1;
    $e = $es[$faker->numberBetween(0,$ce)];

    return [
        'expediente_fk' => $e->id,
        'fecha_modificacion' => $faker->dateTimeBetween($e->fecha_creacion, '2025-01-01')
    ];
});

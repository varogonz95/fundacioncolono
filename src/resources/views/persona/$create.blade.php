@component('components.forms.persona')

    @slot('cedula_model', 'cedula')
    @slot('cedula_value', 'cedula')
    @slot('cedula_help')
        <p class="help-block">
            <small>Reemplace las equis (x) por los números de la cédula correspondiente.</small>
        </p>
    @endslot

    @slot('nombre_model', 'nombre')
    @slot('nombre_value', 'nombre')

    @slot('apellidos_model', 'apellidos')
    @slot('apellidos_value', 'apellidos')

    @slot('telefonos_model', 'telefonos')
    @slot('telefonos_value', 'telefonos')

    {{-- ----------------UBICACION SLOTS------------ --}}
    @slot('provincia_model', 'provincia')
    @slot('provincia_options_expression', 'p as p.name for p in provincias track by p.cod')
    @slot('provincia_onchanged_handler', 'updateCantones(provincia.cod)')

    @slot('canton_model', 'canton')
    @slot('canton_list', 'cantones')
    @slot('canton_options_expression', 'c as c.name for c in cantones track by c.cod')
    @slot('canton_onchanged_handler', 'updateDistritos(provincia.cod, canton.cod)')

    @slot('distrito_model', 'distrito')
    @slot('distrito_list', 'distritos')
    @slot('distrito_options_expression', 'd as d.name for d in distritos track by d.cod')
    {{-- --------------------------------------------- --}}

    @slot('direccion_model', 'direccion')
    @slot('direccion_value', 'direccion')

    @slot('contactos_model', 'contactos')
    @slot('contactos_value', 'contactos')

@endcomponent

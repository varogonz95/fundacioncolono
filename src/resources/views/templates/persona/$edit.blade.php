@component('components.forms.persona')

    @slot('cedula_model', 'update.persona.cedula')
    @slot('cedula_value', 'selected.persona.cedula')
    @slot('cedula_help', '')
        {{-- ADD OVERRIDE OPTION TO ENABLE CEDULA FIELD EDITION --}}
    {{-- @endslot --}}

    @slot('nombre_model', 'update.persona.nombre')
    @slot('nombre_value', 'selected.persona.nombre')

    @slot('apellidos_model', 'update.persona.apellidos')
    @slot('apellidos_value', 'selected.persona.apellidos')

    @slot('telefonos_model', 'update.persona.telefonos')
    @slot('telefonos_value', 'selected.persona.telefonos')

    {{-- ----------------UBICACION SLOTS------------ --}}
    @slot('provincia_model', 'update.persona.provincia')
    @slot('provincia_options_expression', 'p as p.name for p in provincias track by p.cod')
    @slot('provincia_onchanged_handler', 'updateCantones(update.persona.provincia.cod)')

    @slot('canton_model', 'update.persona.canton')
    @slot('canton_list', 'cantones')
    @slot('canton_options_expression', 'c as c.name for c in cantones track by c.cod')
    @slot('canton_onchanged_handler', 'updateDistritos(update.persona.provincia.cod, update.persona.canton.cod)')

    @slot('distrito_model', 'update.persona.distrito')
    @slot('distrito_list', 'distritos')
    @slot('distrito_options_expression', 'd as d.name for d in distritos track by d.cod')
    {{-- --------------------------------------------- --}}

    @slot('direccion_model', 'update.persona.direccion')
    @slot('direccion_value', 'selected.persona.direccion')

    @slot('contactos_model', 'update.persona.contactos')
    @slot('contactos_value', 'selected.persona.contactos')

@endcomponent

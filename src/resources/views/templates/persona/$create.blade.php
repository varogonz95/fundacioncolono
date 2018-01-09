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

    @slot('ubicacion')
        field="ubicacion"
        required
    @endslot

    @slot('direccion_model', 'direccion')
    @slot('direccion_value', 'direccion')

    @slot('contactos_model', 'contactos')
    @slot('contactos_value', 'contactos')

@endcomponent

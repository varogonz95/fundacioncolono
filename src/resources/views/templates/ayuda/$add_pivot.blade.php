@component('components.forms.ayuda_expedientes', ['isAttach' => true])

    {{-- THIS IS A TEST ONLY --}}

    @slot('ayuda_model', 'ayudas[0]')
    @slot('ayuda_options_expression', 'a as a.descripcion for a in ayudas track by a.id')
    
    @slot('monto_model', 'create_monto')
    @slot('monto_value', '')

    @slot('detalle_value', '')

@endcomponent
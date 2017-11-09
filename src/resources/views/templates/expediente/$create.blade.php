
@component('components.forms.expediente')

    @slot('descripcion_model', 'descripcion')
    @slot('descripcion_value', 'descripcion')

    @slot('hasReferenteOtro_model', 'hasReferenteOtro')
    @slot('hasReferenteOtro_init_expression', 'hasReferenteOtro = false')
    @slot('hasReferenteOtro_value', 'hasReferenteOtro')

    @slot('referente_otro_model', 'referente_otro')
    @slot('newReferente_model', 'newReferente')
    @slot('newReferente_value', 'newReferente')
    @slot('newReferente_init_expression', 'newReferente = false')

    @slot('referente_model', 'referente')
    @slot('referentes_list', 'referentes')
    @slot('referentes_limit', '20')

    @slot('prioridad_model', 'prioridad')
    @slot('prioridad_list', 'prioridades')

    @slot('estado_model', 'estado')
    @slot('estados_list', 'estados')

@endcomponent

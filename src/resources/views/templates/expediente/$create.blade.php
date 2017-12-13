
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

    @slot('pago_inicio_model', 'pago_inicio')
    @slot('pago_inicio_value', 'pago_inicio')

    @slot('pago_final_model', 'pago_final')
    @slot('pago_final_value', 'pago_final')
    
    @slot('fecha_desde_model', 'datePickers.from.date')
    @slot('fecha_desde_is_open', 'datePickers.from.open')
    
    @slot('fecha_hasta_model', 'datePickers.to.date')
    @slot('fecha_hasta_is_open', 'datePickers.to.open')
    @slot('fecha_hasta_min_date', 'datePickers.from.date')

@endcomponent

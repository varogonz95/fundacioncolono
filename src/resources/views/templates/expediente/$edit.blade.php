@component('components.forms.expediente')

	@slot('descripcion_model', 'update.caso.descripcion')
	@slot('descripcion_value', 'selected.descripcion')

	@slot('hasReferenteOtro_model', 'update.caso.hasReferenteOtro')
	@slot('hasReferenteOtro_init_expression', 'update.caso.hasReferenteOtro = update.caso.referente_otro !== null')
	@slot('hasReferenteOtro_value', 'update.caso.hasReferenteOtro')

	@slot('referente_otro_model', 'update.caso.referente_otro')

	@slot('newReferente_model', 'update.caso.newReferente')
	@slot('newReferente_init_expression', 'update.caso.newReferente = false')
	@slot('newReferente_value', 'update.caso.newReferente')

	@slot('referente_model', 'update.caso.referente_selected')
	@slot('referentes_list', 'referentes')
	@slot('referentes_limit', '20')

	@slot('prioridad_model', 'update.caso.prioridad_selected')
	@slot('prioridad_list', 'prioridades')

	@slot('estado_model', 'update.caso.estado_selected')
	@slot('estados_list', 'estados')

	@slot('pago_inicio_model', 'update.caso.pago_inicio')
	@slot('pago_inicio_value', 'selected.pago_inicio')

	@slot('pago_final_model', 'update.caso.pago_final')
	@slot('pago_final_value', 'selected.pago_final')
	
	@slot('fecha_desde_model', 'update.caso.datePickers.from.date')
	@slot('fecha_desde_is_open', 'update.caso.datePickers.from.open')
	
	@slot('fecha_hasta_model', 'update.caso.datePickers.to.date')
	@slot('fecha_hasta_is_open', 'update.caso.datePickers.to.open')
	@slot('fecha_hasta_min_date', 'update.caso.datePickers.from.date')

@endcomponent
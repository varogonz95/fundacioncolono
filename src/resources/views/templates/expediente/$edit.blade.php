@component('components.forms.expediente')

	@slot('descripcion_options')
		ng-model="update.caso.descripcion"
		ng-value="selected.descripcion"
	@endslot

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

	@slot('prioridad_options')
        ng-model="update.caso.prioridad_selected"
        ng-options="p.name for p in prioridades track by p.id"
	@endslot
	
	@slot('estado_options')
        ng-model="update.caso.estado_selected"
        ng-options="e.name for e in estados track by e.id"
    @endslot

	@slot('approval_on', 'update.caso.estado_selected.id === 1')

	@slot('pago_inicio_options')
		ng-model="update.caso.pago_inicio"
		ng-value="selected.pago_inicio"
	@endslot
	
	@slot('pago_final_options')
		ng-model="update.caso.pago_final"
		ng-value="selected.pago_final"
	@endslot

    @slot('fecha_desde_options')
        ng-model="update.caso.datePickers.from.date"
        ng-click="update.caso.datePickers.from.open = true"
        is-open="update.caso.datePickers.from.open"
        ng-required="update.caso.estado_selected.id === 1"
    @endslot
    
    @slot('fecha_hasta_options')
        ng-model="update.caso.datePickers.to.date"
        ng-click="update.caso.datePickers.to.open = true"
        is-open="update.caso.datePickers.to.open"
        datepicker-options="{minDate: update.caso.datePickers.from.date}"
        ng-required="update.caso.estado_selected.id === 1"
    @endslot

@endcomponent
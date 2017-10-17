@component('components.forms.ayuda_expedientes', ['isAttach' => false])

    @slot('descripcion_value', 'ayuda.descripcion')

    @slot('detalle_model', 'ayuda.update.pivot.detalle')
    @slot('detalle_value', 'ayuda.pivot.detalle')

    @slot('monto_model', 'ayuda.update.monto')
    @slot('monto_value', 'ayuda.pivot.monto')

@endcomponent
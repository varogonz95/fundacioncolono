<article id="selectedexpediente" class="col-md-4 col-md-offset-1" >
    <div  style="height:370px">
    <header>
        <h3>
            Expedientes Asignados
            <small class="text-nowrap">Total asignado: @{{ selected.total }}</small>
            <ngIf ng-if="!selected.archivado">
                <button class="btn btn-sm btn-show btn-outline">
                    <span class="glyphicon glyphicon-plus"></span>
                    Asignar expediente
                </button>
            </ngIf>
        </h3>
    </header>
  </div>
</article>

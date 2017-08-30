<div @yield('modal-id') class="modal fade" tabindex="-1" role="dialog" @yield('modal-controller')>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <header class="modal-header">
                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close" style="display:block;margin-left:10px"><span aria-hidden="true">&times;</span></button>
                @yield('modal-title')
            </header>
            <section class="modal-body">
                @yield('modal-body')
            </section>
            @yield('modal-footer')
        </div>
    </div>
</div>

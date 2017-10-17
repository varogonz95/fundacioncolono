<div id="{{ $id }}" class="animatedModal animated container">

    <header class="animatedModal-header row">
        {{ $header_content }}
    </header>

    <section class="animatedModal-content row {{ $content_classes }}">
        {{ $slot }}
    </section>

</div>

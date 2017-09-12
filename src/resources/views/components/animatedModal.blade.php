<div id="{{ $id }}" class="animatedModal animated container">

    <header class="animatedModal-header">
        {{ $header_content }}
    </header>

    <section class="animatedModal-content {{ $content_classes }}">
        {{ $slot }}
    </section>

</div>

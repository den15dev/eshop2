<div class="modal-container">
    <div class="modal-win" id="flashModal">
        <button class="btn-icon modal-close-btn">
            <span class="icon-x-lg"></span>
        </button>

        @if($type === 'info')
            <div class="modal-icon info"><span class="icon-info-circle"></span></div>
        @elseif($type === 'success')
            <div class="modal-icon success"><span class="icon-check2-circle"></span></div>
        @elseif($type === 'warning')
            <div class="modal-icon warning"><span class="icon-exclamation-triangle"></span></div>
        @endif

        <p class="mb-45 {{ 'text-' . $align }}">
            {!! $content !!}
        </p>
        <button class="mx-auto" id="flashOkBtn">Ok</button>
    </div>
</div>
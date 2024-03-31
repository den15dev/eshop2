@php
    $classlist = 'quantity-btns_cont';
    $classlist .= isset($twosizes) && $twosizes ? ' twosizes' : '';
    $classlist .= isset($hidden) && $hidden ? ' hidden' : '';
@endphp
<div class="{{ $classlist }}" data-id="{{ $skuid }}">
    <button class="quantity-btns_minus">
        <svg viewBox="0 0 10 2"><use href="#minusIcon"/></svg>
    </button>
    <input class="quantity-btns_input" name="qty" type="text" value="{{ $incart }}">
    <button class="quantity-btns_plus">
        <svg viewBox="0 0 12 12"><use href="#plusIcon"/></svg>
    </button>
</div>
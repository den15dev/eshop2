@extends('site.layout')

@section('page_title', __('errors.403') . ' - ' . __('general.app_name'))

@section('main_content')
<div class="http-error-cont">{{ __('errors.403') }}</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainElem = document.querySelector('main');
        const errorContElem = mainElem.querySelector('.http-error-cont');
        errorContElem.style.marginTop = (mainElem.clientHeight - errorContElem.clientHeight)/2 + 'px';
    });
</script>
@endsection
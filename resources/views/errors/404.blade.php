@php
    $layout = preg_match('/\/admin\//', request()->path())
        ? (request()->user()->isAdmin() || config('app.admin_demo') ? 'admin.layout' : 'site.layout')
        : 'site.layout';
@endphp

@extends($layout)

@section('page_title', __('errors.404') . ' - ' . __('general.app_name'))

@section('main_content')
<div class="http-error-cont">{{ __('errors.404') }}</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainElem = document.querySelector('main');
        const errorContElem = mainElem.querySelector('.http-error-cont');
        errorContElem.style.marginTop = (mainElem.clientHeight - errorContElem.clientHeight)/2 + 'px';
    });
</script>
@endsection

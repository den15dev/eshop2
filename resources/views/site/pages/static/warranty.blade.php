@extends('site.layout')

@section('page_title', __('warranty.warranty') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-4">{{ __('warranty.warranty') }}</h3>

        <p>
            {{ __('warranty.defects.title') }}:
        </p>

        <ul class="text-list mb-3">
            <li>{{ __('warranty.defects.same_brand') }};</li>
            <li>{{ __('warranty.defects.recalculation') }};</li>
            <li>{{ __('warranty.defects.price_reduction') }};</li>
            <li>{{ __('warranty.defects.fixing') }};</li>
            <li>{{ __('warranty.defects.refund') }}.</li>
        </ul>

        <p>
            {{ __('warranty.complex.title') }}:
        </p>

        <ul class="text-list">
            <li>{{ __('warranty.complex.refund') }};</li>
            <li>{{ __('warranty.complex.replacement') }}.</li>
        </ul>
    </div>
@endsection
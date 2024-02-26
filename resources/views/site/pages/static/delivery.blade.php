@extends('site.layout')

@section('page_title', __('delivery.delivery') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-4">{{ __('delivery.delivery') }}</h3>

        <h4 class="mt-45 mb-3">{{ __('delivery.express.title') }}</h4>
        <p>
            {{ __('delivery.express.pre_payment') }}<br>
            {{ __('delivery.express.in_stock') }}<br>
            {{ __('delivery.express.courier_call') }}<br>
            {{ __('delivery.express.end_time') }}
        </p>
        <p>
            {{ $params->express_cost1->description }}: <span class="fw-semibold">{{ $params->express_cost1->val }}</span><br>
            {{ $params->express_cost2->description }}: <span class="fw-semibold">{{ $params->express_cost2->val }}</span><br>
            {{ $params->express_cost3->description }}: <span class="fw-semibold">{{ $params->express_cost3->val }}</span><br>
        </p>
        <p>
            {{ __('delivery.express.availability') }}
        </p>
        <p>
            {{ __('delivery.express.intervals') }}:
            <ul class="text-list">
                <li>{{ __('delivery.express.from_to', ['start' => '12:00', 'end' => '14:00']) }}</li>
                <li>{{ __('delivery.express.from_to', ['start' => '14:00', 'end' => '16:00']) }}</li>
                <li>{{ __('delivery.express.from_to', ['start' => '16:00', 'end' => '18:00']) }}</li>
                <li>{{ __('delivery.express.from_to', ['start' => '18:00', 'end' => '20:00']) }}</li>
                <li>{{ __('delivery.express.from_to', ['start' => '20:00', 'end' => '22:00']) }}</li>
            </ul>
        </p>

        <h4 class="mt-45 mb-3">{{ __('delivery.regular.title') }}</h4>
        <p>
            {{ __('delivery.regular.courier_call') }}<br>
            {{ __('delivery.regular.end_time') }}
        </p>
        <p>
            {{ __('delivery.regular.cost') }}:<br>
            {{ $params->cost_under10->description }}: <span class="fw-semibold">{{ $params->cost_under10->val }}</span><br>
            {{ $params->cost_10_25->description }}: <span class="fw-semibold">{{ $params->cost_10_25->val }}</span><br>
            {{ $params->cost_25_100->description }}: <span class="fw-semibold">{{ $params->cost_25_100->val }}</span><br>
            {{ $params->cost_100_300->description }}: <span class="fw-semibold">{{ $params->cost_100_300->val }}</span><br>
        </p>
        <p>
            {{ __('delivery.over_300') }}
        </p>

        <h4 class="mt-45 mb-3">{{ __('delivery.conditions.title') }}</h4>

        <ul class="text-list mb-3">
            <li>{{ __('delivery.conditions.access_roads') }}</li>
            <li>{{ __('delivery.conditions.stairs') }}</li>
            <li>{{ __('delivery.conditions.doors') }}</li>
            <li>{{ __('delivery.conditions.threshold') }}</li>
            <li>{{ __('delivery.conditions.lifting') }}</li>
            <li>{{ __('delivery.conditions.paid_entry') }}</li>
            <li>{{ __('delivery.conditions.medical') }}</li>
            <li>{{ __('delivery.conditions.testing') }}</li>
            <li>{{ __('delivery.conditions.additional') }}</li>
        </ul>
        <p>
            {{ __('delivery.over_300') }}
        </p>
    </div>
@endsection
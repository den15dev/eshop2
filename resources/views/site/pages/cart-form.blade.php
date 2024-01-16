<form class="cart-order-form" method="POST" action="{{ route('orders.store') }}" id="cartOrderForm" novalidate>
    @csrf
    <label for="nameInput" class="form-label required">{{ __('cart.form.name') }}:</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @else mb-4 @enderror" id="nameInput" value="{{ old('name') ?? ($user ? $user->name : '') }}">
    @error('name')
    <div id="nameInputFeedback" class="invalid-feedback mb-25">{{ $message }}</div>
    @enderror

    <label for="phoneInput" class="form-label required">{{ __('cart.form.phone') }}:</label>
    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @else mb-4 @enderror" id="phoneInput" value="{{ old('phone') ?? ($user ? $user->phone : '') }}">
    @error('phone')
    <div id="phoneInputFeedback" class="invalid-feedback mb-25">{{ $message }}</div>
    @enderror

    <label for="emailInput" class="form-label">{{ __('cart.form.email') }}:</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @else mb-4 @enderror" id="emailInput" value="{{ old('email') ?? ($user ? $user->email : '') }}">
    @error('email')
    <div id="emailInputFeedback" class="invalid-feedback mb-25">{{ $message }}</div>
    @enderror


    {{-- --------------- Tabs ------------------ --}}

    <nav class="tab-cont mb-4">
        <div class="tab-btn active" role="button" id="deliveryTab">
            {{ __('cart.form.delivery') }}
        </div>
        <div class="tab-btn link" role="button" id="selfDeliveryTab">
            {{ __('cart.form.self_delivery') }}
        </div>
    </nav>

    <div class="tab-pane active" id="deliveryTabPane">
        <label for="delAddrInput" class="form-label required">{{ __('cart.form.delivery_address') }}:</label>
        <input type="text" name="delivery_address" class="form-control @error('delivery_address') is-invalid @else mb-4 @enderror" id="delAddrInput" value="{{ old('delivery_address') ?? ($user ? $user->address : '') }}">
        @error('delivery_address')
        <div id="delAddrInputFeedback" class="invalid-feedback mb-25">{{ $message }}</div>
        @enderror
    </div>

    <div class="tab-pane" id="selfDeliveryTabPane">
        <label for="shopSelect" class="form-label">{{ __('cart.form.shop') }}:</label>
        <select class="form-select mb-4" name="shop_id" aria-label="{{ __('cart.form.shop') }}" id="shopSelect">
            @foreach($shops as $shop)
                @if($loop->first)
                    <option value="{{ $shop->id }}" selected>{{ $shop->address }}</option>
                @else
                    <option value="{{ $shop->id }}">{{ $shop->address }}</option>
                @endif
            @endforeach
        </select>
    </div>


    {{-- --------------- Payment methods ------------------ --}}

    <div class="mb-2">{{ __('cart.form.payment_method') }}:</div>

    <div class="mb-45" id="payMethodCont">
        <div class="form-check" id="payMethodOnlineCont">
            <input class="form-check-input" type="radio" name="payment_method" value="online" id="payMethodOnline" checked>
            <label class="form-check-label" for="payMethodOnline">
                {{ __('cart.form.online') }}
            </label>
        </div>
        <div class="form-check" id="payMethodCardCont">
            <input class="form-check-input" type="radio" name="payment_method" value="card" id="payMethodCard">
            <label class="form-check-label" for="payMethodCard">
                {{ __('cart.form.courier') }}
            </label>
        </div>
        <div class="form-check" id="payMethodCashCont">
            <input class="form-check-input" type="radio" name="payment_method" value="cash" id="payMethodCash">
            <label class="form-check-label" for="payMethodCash">
                {{ __('cart.form.courier_cash') }}
            </label>
        </div>
        <div class="form-check" id="payMethodShopCont" style="display: none">
            <input class="form-check-input" type="radio" name="payment_method" value="shop" id="payMethodShop">
            <label class="form-check-label" for="payMethodShop">
                {{ __('cart.form.pay_in_shop') }}
            </label>
        </div>
    </div>


    <input type="hidden" name="delivery_type" value="delivery">

    <button type="submit" data-checkout="{{ __('cart.form.checkout') }}"  data-submit="{{ __('cart.form.submit_order') }}">{{ __('cart.form.checkout') }}</button>
</form>
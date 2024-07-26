@extends('admin.layout')

@section('page_title',  __('admin/reviews.editing_review') . ' #' . $review->id . ' - ' . __('admin/general.admin_panel'))

@section('page_back')
    <x-admin::back-link :url="route('admin.reviews')" text="{{ __('admin/reviews.reviews') }}" />
@endsection

@section('page_header', __('admin/reviews.editing_review'))

@section('main_content')
    <div>
        <ul class="mb-3">
            <li>
                <span class="lightgrey-text">ID:</span>
                {{ $review->id }}
            </li>
            <li>
                <span class="lightgrey-text">SKU:</span>
                <a href="{{ $sku->url }}" class="link">{{ $sku->name }}</a>
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/reviews.author') }}:</span>
                <a href="{{ route('admin.users.edit', $review->user_id) }}" class="link">{{ $review->user->name }}</a>
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/reviews.created_at') }}:</span>
                {{ $review->created_at->isoFormat('D MMMM YYYY, H:mm:ss') }}
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/reviews.term') }}:</span>
                {{ $review->term->description() }}
            </li>
            <li style="display: flex; column-gap: 0.375rem;">
                <span class="lightgrey-text">{{ __('admin/reviews.mark') }}:</span>
                <x-stars :rating="$review->mark" />
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/reviews.likes') }}:</span>
                {{ $review->likes }}
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/reviews.dislikes') }}:</span>
                {{ $review->dislikes }}
            </li>
        </ul>

        <form class="mb-5" action="{{ route('admin.reviews.update', $review->id) }}" method="POST" id="reviewEditForm">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="pros" class="form-label">
                    {{ __('admin/reviews.pros') }}:
                </label>
                <textarea class="form-control" name="pros" id="pros">{{ $review->pros }}</textarea>
            </div>
            <div class="mb-3">
                <label for="cons" class="form-label">
                    {{ __('admin/reviews.cons') }}:
                </label>
                <textarea class="form-control" name="cons" id="cons">{{ $review->cons }}</textarea>
            </div>
            <div>
                <label for="comnt" class="form-label">
                    {{ __('admin/reviews.comnt') }}:
                </label>
                <textarea class="form-control" name="comnt" id="comnt">{{ $review->comnt }}</textarea>
            </div>
        </form>

        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" id="reviewDeleteForm">
            @method('DELETE')
            @csrf
        </form>

        <div class="manage-btns-cont mb-3">
            <button type="submit" form="reviewEditForm">{{ __('admin/general.save') }}</button>
            <button type="submit" class="btn-bg-red" form="reviewDeleteForm" id="reviewDeleteBtn">{{ __('admin/reviews.delete_review') }}</button>
        </div>

        <div class="small fst-italic">
            <span class="grey-text">{{ __('admin/reviews.delete_review_warning') }}</span>
        </div>
    </div>
@endsection

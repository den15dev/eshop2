@extends('admin.layout')

@section('page_title',  __('admin/users.user_managing') . ' ' . $user->id . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/users.user_managing'))

@section('main_content')
    <div>
        @if($user->image)
            <div class="user-edit_img-cont mb-3">
                <img src="{{ $user->image_url }}" alt="{{ $user->name }}">
            </div>
        @endif

        <ul class="mb-4">
            <li>
                <span class="lightgrey-text">ID:</span>
                {{ $user->id }}
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/users.role') }}:</span>
                <span class="user-role_{{ $user->role }}">{{ $user->role }}</span>
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/users.name') }}:</span>
                {{ $user->name }}
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/users.email') }}:</span>
                {{ $user->email }}
                @if($user->email_verified_at)
                    <span class="user-edit_email-verified">({{ __('admin/users.verified') }})</span>
                @else
                    <span class="user-edit_email-not-verified">({{ __('admin/users.not_verified') }})</span>
                @endif
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/users.registration_date') }}:</span>
                {{ $user->created_at->isoFormat('D MMMM YYYY, H:mm:ss') }}
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/users.phone') }}:</span>
                {{ $user->phone }}
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/users.address') }}:</span>
                {{ $user->address ?? '-' }}
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/users.completed_orders') }}:</span>
                {{ $user->completed_orders }}
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/users.cancelled_orders') }}:</span>
                {{ $user->cancelled_orders }}
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/users.active_orders') }}:</span>
                {{ $user->active_orders }}
            </li>
            <li>
                <span class="lightgrey-text">{{ __('admin/users.reviews_count') }}:</span>
                {{ $user->reviews_count }}
            </li>
        </ul>

        @if($current_user?->isBoss() || !$user->isAdmin())
            <div class="mb-5" id="banUserSection" data-id="{{ $user->id }}">
                <div class="preloader-cont">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="userBanSwitch" @checked(!$user->is_active)>
                        <label class="form-check-label" for="userBanSwitch">{{ __('admin/users.ban') }}</label>
                    </div>
                    <img class="preloader pl-switch hidden" src="{{ asset('img/preloader.gif') }}" alt="">
                </div>

                <div class="small grey-text fst-italic">
                    {{ __('admin/users.ban_note') }}
                </div>
            </div>
        @endif

        <div class="manage-btns-cont mb-3">
            @if($current_user?->isBoss())
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="changeRoleForm" data-name="{{ $user->name }}">
                    @method('PUT')
                    @csrf
                    @if(!$user->isBoss())
                        @if($user->isAdmin())
                            <input type="hidden" name="role" value="user">
                            <button type="submit">{{ __('admin/users.buttons.user') }}</button>
                        @else
                            <input type="hidden" name="role" value="admin">
                            <button type="submit">{{ __('admin/users.buttons.admin') }}</button>
                        @endif
                    @endif
                </form>
            @endif

            @if(!$user->isAdmin() && (!$current_user || $current_user->id !== $user->id))
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="deleteUserForm" data-name="{{ $user->name }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn-bg-red">{{ __('admin/users.buttons.delete') }}</button>
                </form>
            @endif
        </div>

        @if(!$user->isAdmin() && (!$current_user || $current_user->id !== $user->id))
            <div class="small fst-italic">
                <span class="fw-semibold">{{ __('admin/general.caution') }}</span>
                <span class="grey-text">{{ __('admin/users.delete_user_warning') }}</span>
            </div>
        @endif
    </div>
@endsection

<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();

        return view('site.pages.user-profile', compact('user'));
    }


    public function store(
        UpdateProfileRequest $request,
    ) {
        $message = 'Профиль обновлён.';

        $user = Auth::user();

        $user->phone = $request->input('phone');

        $user->save();

        if ($message) {
            $request->session()->flash('message', [
                'type' => 'info',
                'content' => $message,
                'align' => 'center',
            ]);
        }

        return back();
    }
}

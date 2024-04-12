<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Users\Requests\UpdateProfileRequest;
use App\Modules\Users\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        UserService $userService,
    ) {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $source_path = $request->file('image')->path();
            $orig_name = $request->file('image')->getClientOriginalName();
            $orig_basename = pathinfo($orig_name, PATHINFO_FILENAME);

            $userService->saveImage($source_path, $orig_basename, $user->id);
            $user->image = $orig_basename;

        } elseif ($request->has('new_password')) {
            $user->password = Hash::make($request->validated('new_password'));

        } else {
            foreach ($request->validated() as $key => $value) {
                $user->$key = $value;
            }
        }

        $user->save();

        $request->flashInfoMessage(__('user-profile.updated'));

        return back();
    }
}

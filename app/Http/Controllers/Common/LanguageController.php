<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Modules\Languages\LanguageService;
use App\Modules\Languages\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LanguageController extends Controller
{
    public function set(Request $request)
    {
        $new_lang_id = $request->input('new_language');
        abort_unless(Language::where('id', $new_lang_id)->exists(), 404);

        $cookie = cookie()->forever('lang', $new_lang_id);

        if (config('app.lang_url_priority')) {
            return $this->withURLPriority($cookie, $new_lang_id);
        }
        return $this->withLanguagePriority($cookie);
    }


    public function translations(): JsonResponse
    {
        $trans_arr = [];

        $trans_arr['general'] = Lang::get('general', [], app()->getLocale());
        $trans_arr['comparison'] = Lang::get('comparison', [], app()->getLocale());

        return response()->json($trans_arr);
    }


    private function withLanguagePriority($cookie)
    {
        return back()->withCookie($cookie);
    }


    private function withURLPriority($cookie, $new_lang_id) {
        $previous_url = str_replace(url('/'), '', url()->previous());
        $modified_url = LanguageService::modifyURL($previous_url, $new_lang_id);
        return redirect($modified_url)->withCookie($cookie);
    }
}

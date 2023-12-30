<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Modules\Currencies\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __invoke(Request $request)
    {
        $new_curr_id = $request->input('new_currency');
        abort_unless(Currency::where('id', $new_curr_id)->exists(), 404);

        $cookie = cookie()->forever('curr', $new_curr_id);

        return back()->withCookie($cookie);
    }
}

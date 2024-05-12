<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AjaxRequest;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class AjaxController extends Controller
{
    public function post(AjaxRequest $request): JsonResponse
    {
        $className = 'App\\Admin\\' . ucfirst(Str::plural($request->service)) . '\\' . ucfirst($request->service) . 'Service';
        $service = app()->make($className);

        if (method_exists($service, $request->action)) {
            $response = call_user_func_array([$service, $request->action], $request->args);

            return response()->json($response);
        }

        return response()->json(['message' => 'Not Found'], 404);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AjaxRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AjaxController extends Controller
{
    public function getJson(Request $request): JsonResponse
    {
        $query = $request->query();
        $response = $this->getResponse($query['service'], $query['action'], $query['args']);

        return $response
            ? response()->json($response)
            : response()->json(['message' => 'Not Found'], 404);
    }


    public function getHtml(Request $request): View|Response
    {
        $query = $request->query();
        $response = $this->getResponse($query['service'], $query['action'], $query['args']);

        return $response ?: response('Not found', 404);
    }


    public function post(AjaxRequest $request): JsonResponse
    {
        $response = $this->getResponse($request->service, $request->action, $request->args);

        return $response
            ? response()->json($response)
            : response()->json(['message' => 'Not Found'], 404);
    }


    private function getResponse(string $service, string $action, array $args): \stdClass|View|null
    {
        $response_ok = new \stdClass();
        $response_ok->status = 'ok';

        $className = 'App\\Admin\\' . ucfirst(Str::plural($service)) . '\\' . ucfirst($service) . 'Service';
        $service_instance = app()->make($className);

        if (method_exists($service_instance, $action)) {
            $response = call_user_func_array([$service_instance, $action], $args);

            return $response ?? $response_ok;
        }

        return null;
    }
}

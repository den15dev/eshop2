<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Dashboard\DashboardService;
use App\Admin\Products\ProductService;
use App\Http\Controllers\Controller;
use App\Modules\Categories\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(
        Request $request,
        DashboardService $dashboardService,
        ProductService $productService,
    )
    {
        $years = $dashboardService->getYears();
        $categories = $productService->getCategories(CategoryService::getAll());
        $currencies = $dashboardService->getCurrencies();
        $state = $dashboardService->getPageState($request->query());

        $charts = $dashboardService->getCharts($request->query());

        return view('admin.pages.dashboard', compact(
            'charts',
            'years',
            'categories',
            'currencies',
            'state',
        ));
    }


    public function charts(
        Request $request,
        DashboardService $dashboardService,
    ): JsonResponse
    {
        $charts_data = $dashboardService->getCharts($request->query());

        return response()->json($charts_data);
    }
}

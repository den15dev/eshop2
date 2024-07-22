<?php

namespace App\Http\Controllers\Admin;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Reviews\ReviewService;
use App\Modules\Reviews\ReviewService as SiteReviewService;
use App\Http\Controllers\Controller;
use App\Modules\Reviews\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        private readonly IndexTableService $tableService,
        private readonly ReviewService $reviewService,
        private readonly SiteReviewService $siteReviewService,
    ){}


    public function index(Request $request): View
    {
        $table_data = $this->getTableData($request);
        $state = $this->reviewService->getPageState($request->query());

        return view('admin.pages.reviews.index', array_merge(compact(
            'state',
        ), $table_data));
    }


    public function table(Request $request): View
    {
        return view('admin.includes.index-table', $this->getTableData($request));
    }


    private function getTableData(Request $request): array
    {
        $table_name = ReviewService::TABLE_NAME;
        $this->tableService->initTable($table_name, $request->query());

        $col_cookie_name = ReviewService::COLUMNS_COOKIE;
        $cookie = $request->cookie($col_cookie_name);
        $column_prefs = $cookie ? json_decode($cookie) : null;

        $row_links = ReviewService::ROW_LINKS;

        $column_list = $this->tableService->getColumnList($column_prefs);
        $per_page_list = IndexTableService::getPerPageList();

        $current_columns = $this->tableService->getCurrentColumns($column_prefs);

        $query = $this->reviewService->buildIndexQuery($request->query(), $this->tableService);
        $items = $query->paginate(IndexTableService::$per_page);

        return compact(
            'column_list',
            'col_cookie_name',
            'per_page_list',
            'table_name',
            'current_columns',
            'items',
            'row_links',
        );
    }


    public function edit(int $id): View
    {
        $review = $this->reviewService->getReview($id);
        $sku = $this->reviewService->getSku($review->sku_id);

        return view('admin.pages.reviews.edit', compact(
            'review',
            'sku',
        ));
    }


    public function update(Request $request, $id): RedirectResponse
    {
        $review = Review::find($id);
        $review->pros = $request->pros;
        $review->cons = $request->cons;
        $review->comnt = $request->comnt;
        $review->save();

        session()->flash('message', [
            'type' => 'info',
            'content' => __('admin/general.messages.changes_saved'),
            'align' => 'center',
        ]);

        return back();
    }


    public function destroy($id): RedirectResponse
    {
        $review = Review::find($id);
        $sku_id = $review->sku_id;
        $review->delete();

        $this->siteReviewService->updateSkuRating($sku_id);

        session()->flash('message', [
            'type' => 'info',
            'content' => __('admin/reviews.messages.review_deleted', ['id' => $id]),
            'align' => 'center',
        ]);

        return redirect()->route('admin.reviews');
    }
}

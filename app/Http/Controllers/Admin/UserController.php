<?php

namespace App\Http\Controllers\Admin;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Users\UserService;
use App\Http\Controllers\Controller;
use App\Modules\Users\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly IndexTableService $tableService,
        private readonly UserService $userService,
    ){}


    public function index(Request $request): View
    {
        $table_data = $this->getTableData($request);
        $state = $this->userService->getPageState($request->query());

        return view('admin.pages.users.index', array_merge(compact(
            'state',
        ), $table_data));
    }


    public function table(Request $request): View
    {
        return view('admin.includes.index-table', $this->getTableData($request));
    }


    private function getTableData(Request $request): array
    {
        $table_name = UserService::TABLE_NAME;
        $this->tableService->initTable($table_name, $request->query());

        $col_cookie_name = UserService::COLUMNS_COOKIE;
        $cookie = $request->cookie($col_cookie_name);
        $column_prefs = $cookie ? json_decode($cookie) : null;

        $row_links = UserService::ROW_LINKS;

        $column_list = $this->tableService->getColumnList($column_prefs);
        $per_page_list = IndexTableService::getPerPageList();

        $current_columns = $this->tableService->getCurrentColumns($column_prefs);

        $query = $this->userService->buildIndexQuery($request->query(), $this->tableService);
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
        $user = User::find($id);

        return view('admin.pages.users.edit', compact(
            'user',
        ));
    }


    public function update(Request $request, $id): RedirectResponse
    {
        /*$validated = $request->validate([
            'status' => ['required', Rule::enum(OrderStatus::class)],
        ]);

        Order::find($id)->update($validated);

        $message = __('admin/orders.messages.status_updated', ['id' => $id, 'status' => OrderStatus::from($validated['status'])->description()]);

        session()->flash('message', [
            'type' => 'info',
            'content' => $message,
            'align' => 'center',
        ]);*/

        return back();
    }
}

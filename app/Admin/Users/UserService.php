<?php

namespace App\Admin\Users;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Builder as EBuilder;

class UserService
{
    public const TABLE_NAME = 'users';
    public const COLUMNS_COOKIE = 'cls_users';
    public const ROW_LINKS = true;


    public function buildIndexQuery(array $query, IndexTableService $tableService): EBuilder
    {
        $db_query = User::select(
                'users.*',
            );

        if (isset($query['search'])) {
            $db_query = $tableService->constrainBySearchStr($db_query, $query['search']);
        }

        if (isset($query['chb'])) {
            $checkboxes = [];
            foreach ($query['chb'] as $key => $val) {
                $checkboxes[$key] = $val === 'true';
            }

            $db_query = $this->constrainByCheckboxes($db_query, $checkboxes);
        }

        return isset($query['sort'])
            ? $tableService->orderQuery($db_query, $query)
            : $db_query->orderByDesc('users.id');
    }


    public function getPageState($query): \stdClass
    {
        $state = new \stdClass();

        $state->search = $query['search'] ?? null;
        $state->banned = isset($query['chb']['banned']) ? $query['chb']['banned'] === 'true' : false;
        $state->admins = isset($query['chb']['admins']) ? $query['chb']['admins'] === 'true' : false;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }


    private function constrainByCheckboxes(EBuilder $db_query, array $checkboxes): EBuilder
    {

        if (isset($checkboxes['banned'])) {
            $db_query = $db_query->where('is_active', 'false');
        }

        if (isset($checkboxes['admins'])) {
            $db_query = $db_query->orWhere('role', 'admin');
        }

        return $db_query;
    }
}
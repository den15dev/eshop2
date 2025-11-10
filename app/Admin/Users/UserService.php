<?php

namespace App\Admin\Users;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Orders\Enums\OrderStatus;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public const TABLE_NAME = 'users';
    public const COLUMNS_COOKIE = 'cls_users';
    public const ROW_LINKS = true; // A whole table row will be a link (every <td> content will be wrapped by <a> tag)


    public function buildIndexQuery(array $query, IndexTableService $tableService): EBuilder
    {
        $db_query = User::select(
                'users.*',
            );

        $isBoss = Auth::user()->isBoss();
        if (!$isBoss) {
            $db_query->where('role', '!=', 'boss');
        }

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
            : $db_query->orderByDesc(self::TABLE_NAME . '.id');
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
            $db_query = $db_query->where('is_active', false);
        }

        if (isset($checkboxes['admins'])) {
            $db_query = $db_query->orWhere('role', 'admin');
        }

        return $db_query;
    }


    public function getUser(int $user_id): ?User
    {
        return User::withCount(
            [
                'orders as completed_orders' => function (EBuilder $query) {
                    $query->where('status', OrderStatus::Completed);
                },
                'orders as cancelled_orders' => function (EBuilder $query) {
                    $query->where('status', OrderStatus::Cancelled);
                },
                'orders as active_orders' => function (EBuilder $query) {
                    $query->whereNot('status', OrderStatus::Completed)
                        ->whereNot('status', OrderStatus::Cancelled);
                },
            ]
        )->withCount('reviews')
         ->find($user_id);
    }


    public function updateBanStatus(int $user_id, bool $banned): \stdClass
    {
        $user = User::find($user_id);
        $user->is_active = !$banned;
        $user->save();

        $response = new \stdClass();
        $response->user_id = $user_id;
        $response->banned = $banned;
        $response->message = $banned
            ? __('admin/users.messages.user_banned', ['name' => $user->name])
            : __('admin/users.messages.user_unbanned', ['name' => $user->name]);

        return $response;
    }


    public function deleteUserImage(int $user_id): void
    {
        $dir = Storage::disk('images')->path(User::IMG_DIR . '/' . $user_id);

        if (is_dir($dir)) {
            $images = array_diff(scandir($dir), ['.', '..']);
            foreach ($images as $img) {
                unlink($dir . '/' . $img);
            }
            rmdir($dir);
        }
    }
}

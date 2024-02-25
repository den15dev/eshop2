<?php

namespace App\Modules\StaticPages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class StaticPage extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public array $translatable = ['name'];


    public function staticPageParams(): HasMany
    {
        return $this->hasMany(StaticPageParam::class);
    }


    /**
     * Get parameters for a static page.
     */
    public function getParams(string $slug): \stdClass
    {
        $params_db = StaticPageParam::join('static_pages', 'static_pages.id', '=', 'static_page_params.static_page_id')
            ->select(['static_page_params.name', 'val', 'description'])
            ->where('static_pages.slug', $slug)
            ->get();

        $params = new \stdClass();

        foreach ($params_db as $param_db) {
            $prop_obj = new \stdClass();
            $prop_obj->val = $param_db->val;
            $prop_obj->description = $param_db->description;

            $prop = $param_db->name;
            $params->$prop = $prop_obj;
        }

        return $params;
    }
}

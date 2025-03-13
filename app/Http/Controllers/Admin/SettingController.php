<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Settings\Requests\SettingRequest;
use App\Admin\Settings\Requests\SettingStoreRequest;
use App\Http\Controllers\Controller;
use App\Modules\Languages\LanguageService;
use App\Modules\Settings\Enums\DataType;
use App\Modules\Settings\Models\Setting;
use App\Modules\Settings\SettingService;
use App\Admin\Settings\SettingService as AdmSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        private readonly AdmSettingService $settingService
    ) {}


    public function edit(): View
    {
        $settings = SettingService::getAll();

        return view('admin.pages.settings.edit', compact(
            'settings',
        ));
    }


    public function update(SettingRequest $request, string $id): RedirectResponse
    {
        $this->settingService->updateSetting($id, $request->val);

        $request->flashSuccessMessage(__('admin/general.messages.changes_saved'));

        return back();
    }


    public function create(): View
    {
        $languages = LanguageService::getAll();

        return view('admin.pages.settings.create', compact('languages'));
    }


    public function store(SettingStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $setting = new Setting();
        $setting->id = $validated['id'];
        $setting->name = $request->name;
        $setting->data_type = $request->data_type;

        if ($request->data_type === DataType::Array->value) {
            $setting->val = explode("\r\n", trim($validated['val']));
        } else {
            $setting->val = $validated['val'];
        }

        $description = array_filter($request->description);
        if (count($description)) {
            $setting->description = $description;
        }

        $setting->save();

        $request->flashSuccessMessage(__('admin/settings.added'));

        return redirect()->route('admin.settings');
    }
}

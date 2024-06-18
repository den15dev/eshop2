<form @isset($spec) data-spec-id="{{ $spec->id }}" @endisset>
    @isset($spec)
    <div class="small lightgrey-text mb-1">#{{ $spec->sort }}, {{ $spec->skus_count ? __('admin/specifications.used_in', ['num' => $spec->skus_count]) : __('admin/specifications.not_used') }}</div>
    @endisset

    <div class="spec-item">
        <div class="spec-item_section">
            <div class="spec-item_label">{{ __('admin/specifications.name') }}:</div>
            @foreach($languages as $lang)
                <div class="spec-item_text-cont">
                    @php
                        $id = isset($spec)
                            ? 'spec' . $spec->id . 'Name' . ucfirst($lang->id)
                            : 'newSpecName' . ucfirst($lang->id);
                    @endphp
                    <label for="{{ $id }}" class="form-label">{{ $lang->id }}:</label>
                    <div>
                        <textarea class="form-control"
                                  name="name[{{ $lang->id }}]"
                                  id="{{ $id }}"
                                  @isset($spec){!! $lang->id === app()->getLocale() ? 'data-current-name="true"' : '' !!}@endisset
                                  data-minlines="1">@isset($spec){{ $spec->getTranslation('name', $lang->id, false) }}@endisset</textarea>
                        <div id="{{ $id }}Feedback" class="invalid-feedback"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="spec-item_section mb-2">
            <div class="spec-item_subsection">
                <div>
                    <div class="spec-item_label">{{ __('admin/specifications.units') }}:</div>
                    @foreach($languages as $lang)
                        <div class="spec-item_text-cont">
                            @php
                                $id = isset($spec)
                                    ? 'spec' . $spec->id . 'Units' . ucfirst($lang->id)
                                    : 'newSpecUnits' . ucfirst($lang->id);
                            @endphp
                            <label for="{{ $id }}" class="form-label">{{ $lang->id }}:</label>
                            <div>
                                <input type="text"
                                       class="form-control"
                                       name="units[{{ $lang->id }}]"
                                       value="@isset($spec){{ $spec->getTranslation('units', $lang->id, false) }}@endisset"
                                       id="{{ $id }}" />
                                <div id="{{ $id }}Feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div>
                    <div class="mb-25">
                        @php
                            $id = isset($spec) ? 'specOrderNum' . $spec->id : 'newSpecOrderNum';
                        @endphp
                        <label class="spec-item_label">{{ __('admin/specifications.order') }}:</label>
                        @isset($spec)
                            <input type="hidden" name="old_sort" value="{{ $spec->sort }}" />
                        @endisset
                        <input type="text"
                               class="form-control"
                               name="sort"
                               value="@isset($spec){{ $spec->sort }}@else{{ $specnum + 1 }}@endisset"
                               id="{{ $id }}" />
                        <div id="{{ $id }}Feedback" class="invalid-feedback"></div>
                    </div>

                    <div>
                        <div class="spec-item_checkbox-cont mb-1">
                            <input type="checkbox" class="form-check-input" name="is_filter"
                                   id="isFilter{{ isset($spec) ? $spec->id : '' }}" @isset($spec){{ $spec->is_filter ? 'checked' : '' }}@endisset />
                            <label class="form-check-label"
                                   for="isFilter{{ isset($spec) ? $spec->id : '' }}">{{ __('admin/specifications.is_filter') }}</label>
                        </div>

                        <div class="spec-item_checkbox-cont mb-1">
                            <input type="checkbox" class="form-check-input" name="is_main"
                                   id="isMain{{ isset($spec) ? $spec->id : '' }}" @isset($spec){{ $spec?->is_main ? 'checked' : '' }}@endisset />
                            <label class="form-check-label"
                                   for="isMain{{ isset($spec) ? $spec->id : '' }}">{{ __('admin/specifications.is_main') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="spec-item_btns">
                @isset($spec)
                    <div class="link spec-item_save-btn">{{ __('admin/general.save') }}</div>
                    <div class="red-link spec-item_delete-btn">{{ __('admin/general.delete') }}</div>
                @else
                    <div class="link spec-item_add-btn">{{ __('admin/general.add') }}</div>
                @endisset
            </div>
        </div>
    </div>
</form>
<?php

namespace Tltcms\Orchid\Layouts;

use Tltcms\Enums\ValueType;
use Tltcms\Models\Setting;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SettingListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'settings';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('key', __('Setting'))
                ->filter()
                ->sort()
                ->render(fn(Setting $setting) => Link::make($setting->key)->route('admin.settings.edit', $setting)),

            TD::make('value', __('Value'))
                ->width('60%')
                ->style('word-break: break-word;')
                ->sort()
                ->render(function (Setting $setting) {
                    if ($setting->type == ValueType::Bool) {
                        return view('tltcms::admin.cells.bool', ['bool' => (bool) $setting->value]);
                    } else {
                        return $setting->value;
                    }
                }),

            TD::make('actions', __('Actions'))
                ->alignCenter()
                ->width('100px')
                ->render(fn(Setting $setting) => DropDown::make()
                    ->icon('three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->icon('pencil-square')
                            ->route('admin.settings.edit', $setting),
                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once deleted, the entry cannot be restored.'))
                            ->action(route('admin.settings.edit', ['setting' => $setting, 'method' => 'remove']))
                    ])
                ),
        ];
    }
}

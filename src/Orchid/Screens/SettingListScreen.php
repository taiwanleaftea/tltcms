<?php

namespace Tltcms\Orchid\Screens;

use Tltcms\Models\Setting;
use Tltcms\Orchid\Layouts\SettingListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class SettingListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'settings' => Setting::filters()->defaultSort('key')->paginate(config('tltcms.items', 30)),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Параметры';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus-circle')
                ->route('admin.settings.create')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            SettingListLayout::class,
        ];
    }
}

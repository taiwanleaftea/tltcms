<?php

namespace Tltcms\Orchid\Screens;

use Tltcms\Enums\ValueType;
use Tltcms\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SettingEditScreen extends Screen
{
    /**
     * @var Setting
     */
    public $setting;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Setting $setting): iterable
    {
        return [
            'setting' => $setting,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->setting->exists ? $this->setting->key : 'Новый параметр';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Add'))
                ->icon('plus-circle')
                ->method('createOrUpdate')
                ->canSee(!$this->setting->exists),

            Button::make(__('Save'))
                ->icon('save')
                ->method('createOrUpdate')
                ->canSee($this->setting->exists),

            Link::make(__('Cancel'))
                ->icon('reply')
                ->route('admin.settings'),

            Button::make(__('Delete'))
                ->icon('trash')
                ->method('remove')
                ->canSee($this->setting->exists),
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
            Layout::rows([
                Input::make('setting.key')
                    ->title('Параметр')
                    ->placeholder('Название параметра')
                    ->type('text')
                    ->maxLength(255)
                    ->required(),

                TextArea::make('setting.value')
                    ->title('Значение')
                    ->placeholder('Значение параметра, логические параметры 1 и 0')
                    ->rows(3),

                Select::make('setting.type.value')
                    ->title('Тип параметра')
                    ->options(ValueType::labelsArray())
                    ->required(),

                TextArea::make('setting.comment')
                    ->title('Комментарий')
                    ->placeholder('Комментарий')
                    ->maxlength(255)
                    ->rows(3),
            ]),
        ];
    }

    /**
     * @param Setting $setting
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createOrUpdate(Setting $setting, Request $request): \Illuminate\Http\RedirectResponse
    {
        $message = $setting->exists ? 'обновлён' : 'создан';

        $validated = Validator::make($request->get('setting'), [
            'type.value' => Rule::enum(ValueType::class),
            'key' => [
                'required',
                'max:255',
                Rule::unique('settings')->ignore($setting->id),
            ],
            'value' => 'nullable',
            'comment' => 'nullable|max:255',
        ], [], [
            'type' => 'Тип параметра',
            'key' => 'Параметр',
            'value' => 'Значение',
            'comment' => 'Комментарий',
        ])->validate();

        $validated['type'] = ValueType::from($validated['type']['value']);
        $setting->fill($validated)->save();

        Alert::info("Параметр {$setting->key} $message");

        return redirect()->route('admin.settings');
    }

    /**
     * @param Setting $setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Setting $setting): \Illuminate\Http\RedirectResponse
    {
        $message = "Параметр {$setting->key} удалён";
        $setting->delete();
        Alert::info("$message");

        return redirect()->route('admin.settings');
    }

}
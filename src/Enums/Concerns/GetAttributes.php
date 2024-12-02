<?php

namespace Tltcms\Enums\Concerns;

use Illuminate\Support\Str;
use ReflectionClassConstant;
use Tltcms\Enums\Attributes\Label;

trait GetAttributes
{
    /**
     * @return array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function label($enum): string
    {
        return self::getLabel($enum);
    }

   /**
     * @return array
     */
    public static function labelsArray(): array
    {
        $array = [];

        foreach (self::cases() as $enum) {
            $array[$enum->value] = self::getLabel($enum);
        }

        return $array;
    }

    /**
     * @return array<string,string>
     */
    public static function selectArray(): array
    {
        return collect(self::cases())
            ->map(function ($enum) {
                return [
                    'name' => self::getLabel($enum),
                    'value' => $enum->value,
                ];
            })->toArray();
    }

    /**
     * @return string
     */
    public static function renderOptions(): string
    {
        $labels = self::selectArray();

        return view('modules.elements.options', ['options' => $labels])->render();
    }

    /**
     * @param self $enum
     * @return string
     */
    private static function getLabel(self $enum): string
    {
        $ref = new ReflectionClassConstant(self::class, $enum->name);
        $classAttributes = $ref->getAttributes(Label::class);

        return count($classAttributes) === 0 ? Str::headline($enum->value) : $classAttributes[0]->newInstance()->label;
    }
}

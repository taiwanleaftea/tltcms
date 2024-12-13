<?php

namespace Tltcms\Support;

use Tltcms\Models\Redirect;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Slug
{
    /**
     * @var string
     */
    private string $slug;

    /**
     * @var string
     */
    private string $delimiter;

    /**
     * @var bool
     */
    private bool $keepCapitals;

    /**
     * Conversion table
     * @var array|string[]
     */
    private array $table = [
        "а" => "a",   "б" => "b",   "в" => "v",   "г" => "g",
        "д" => "d",   "е" => "e",   "ё" => "e",   "ж" => "zh",
        "з" => "z",   "и" => "i",   "й" => "j",   "к" => "k",
        "л" => "l",   "м" => "m",   "н" => "n",   "о" => "o",
        "п" => "p",   "р" => "r",   "с" => "s",   "т" => "t",
        "у" => "u",   "ф" => "f",   "х" => "h",   "ц" => "c",
        "ч" => "ch",  "ш" => "sh",  "щ" => "shch", "ъ" => "",
        "ы" => "y",   "ь" => "",    "э" => "e",   "ю" => "yu",
        "я" => "ya",
        "А" => "A",   "Б" => "B",   "В" => "V",   "Г" => "G",
        "Д" => "D",   "Е" => "E",   "Ё" => "E",   "Ж" => "Zh",
        "З" => "Z",   "И" => "I",   "Й" => "J",   "К" => "K",
        "Л" => "L",   "М" => "M",   "Н" => "N",   "О" => "O",
        "П" => "P",   "Р" => "R",   "С" => "S",   "Т" => "T",
        "У" => "U",   "Ф" => "F",   "Х" => "H",   "Ц" => "C",
        "Ч" => "Ch",  "Ш" => "Sh",  "Щ" => "Sрch", "Ъ" => "",
        "Ы" => "Y",   "Ь" => "",    "Э" => "E",   "Ю" => "Yu",
        "Я" => "Ya",
    ];

    /**
     * @param string $stringToSlug
     * @param string $delimiter
     * @param bool $keepCapitals
     * @return string
     */
    public function build(string $stringToSlug, string $delimiter = '-', bool $keepCapitals = false): string
    {
        $this->slug = $stringToSlug;
        $this->delimiter = $delimiter;
        $this->keepCapitals = $keepCapitals;

        $this->replaceSpacesWithDelimiter()
            ->removeInappropriateSymbols()
            ->toLower()
            ->translit();

        return $this->slug;
    }

    /**
     * @param string $model
     * @param string $old
     * @param string $new
     * @return void
     */
    public function updateRedirect(string $model, string $old, string $new): void
    {
        if ($old != $new) {
            $to = Redirect::where([
                ['to', '=', $old],
                ['model', '=', $model],
            ])->get();

            foreach ($to as $item) {
                $item->to = $new;
                $item->save();
            }

            if (!App::environment('test')) {
                Redirect::updateOrCreate(
                    ['from' => $old, 'model' => $model],
                    ['to' => $new, 'model' => $model],
                );
            }
        }
    }

    /**
     * @param string $model
     * @param string $from
     * @return mixed
     */
    public function getRedirect(string $model, string $from): mixed
    {
        return Redirect::where([
                ['from', '=', $from],
                ['model', '=', $model],
            ])->first();
    }

    /**
     * Remove all symbols except russian and latin letters, numbers, '-' and '_' in $this->slug
     *
     * @return $this
     */
    private function removeInappropriateSymbols(): static
    {
        $this->slug = preg_replace('/[^0-9а-яёa-z_-]/iu', '', $this->slug);

        return $this;
    }

    /**
     * Replace spaces with delimiter in $this->slug
     * @return $this
     */
    private function replaceSpacesWithDelimiter(): static
    {
        // Replace multiple spaces with single one and trim slug
        $this->slug = Str::of(preg_replace('!\s+!', ' ', $this->slug))
            ->trim()
            ->replace(' ', $this->delimiter);

        return $this;
    }

    /**
     * Convert $this->slug to lowercase when necessary
     *
     * @return $this
     */
    private function toLower(): static
    {
        if($this->keepCapitals === false){
            $this->slug = Str::lower($this->slug);
        }

        return $this;
    }

    /**
     * Translit string
     *
     * @return $this
     */
    private function translit(): static
    {
        $this->slug = iconv("UTF-8","UTF-8//IGNORE", strtr($this->slug, $this->table));

        return $this;
    }
}

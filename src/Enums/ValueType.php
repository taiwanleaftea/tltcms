<?php

namespace Tltcms\Enums;

use Tltcms\Enums\Attributes\Label;
use Tltcms\Enums\Concerns\GetAttributes;

enum ValueType: string
{
    use GetAttributes;

    #[Label('Логический (да/нет)')]
    case Bool = 'boolean';

    #[Label('Числовой')]
    case Int= 'integer';

    #[Label('Строковый')]
    case Str = 'string';
}

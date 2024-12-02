<?php

namespace Tltcms\Enums;

use Tltcms\Enums\Attributes\Label;
use Tltcms\Enums\Concerns\GetAttributes;

enum PageType: string
{
    use GetAttributes;

    #[Label('Домашняя')]
    case Home = 'home';

    #[Label('Обычная')]
    case Normal = 'normal';

    #[Label('Юридическая информация')]
    case Legal = 'legal';

    #[Label('Контакты')]
    case Contacts = 'contacts';
}

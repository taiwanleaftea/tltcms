<?php

namespace Tltcms\Enums\Attributes;

use Attribute;

#[Attribute]
class Label
{
    public function __construct(public string $label)
    {
    }
}

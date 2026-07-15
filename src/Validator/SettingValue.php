<?php

declare(strict_types=1);

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_CLASS)]
final class SettingValue extends Constraint
{
    public string $invalidEmailMessage = 'setting.value.invalid_email';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}

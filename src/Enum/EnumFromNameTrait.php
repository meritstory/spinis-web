<?php

declare(strict_types=1);

namespace App\Enum;

trait EnumFromNameTrait
{
    public static function fromName(string $name): self
    {
        $qualifiedName = self::class.'::'.$name;

        if (!defined($qualifiedName)) {
            throw new \ErrorException(\sprintf('Undefined constant %s', $qualifiedName));
        }

        return \constant($qualifiedName);
    }

    public static function tryFromName(string $name): ?self
    {
        try {
            return self::fromName($name);
        } catch (\Throwable) {
        }

        return null;
    }
}

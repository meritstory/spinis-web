<?php

declare(strict_types=1);

namespace App\Enum;

enum SettingKeyEnum: string
{
    use EnumFromNameTrait;

    case VERSION = 'version';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $case): string => $case->value, self::cases());
    }

    public function getLabelKey(): string
    {
        return match ($this) {
            self::VERSION => 'setting.key.version',
        };
    }
}

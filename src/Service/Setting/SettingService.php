<?php

declare(strict_types=1);

namespace App\Service\Setting;

use App\Enum\SettingKeyEnum;
use App\Repository\SettingRepository;

final readonly class SettingService
{
    public function __construct(
        private SettingRepository $settingRepository,
    ) {
    }

    public function get(SettingKeyEnum $key): ?string
    {
        return $this->settingRepository->findOneBy(['key' => $key->value])?->getValue();
    }

    public function getRequired(SettingKeyEnum $key): string
    {
        $value = $this->get($key);

        if ($value === null || $value === '') {
            throw new \RuntimeException(sprintf('Setting "%s" is not configured.', $key->value));
        }

        return $value;
    }
}

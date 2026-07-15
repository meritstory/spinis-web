<?php

declare(strict_types=1);

namespace App\Twig;

use App\Repository\LinkRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(private readonly LinkRepository $linkRepository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('link_url', $this->getLinkUrl(...)),
        ];
    }

    public function getLinkUrl(string $key): ?string
    {
        return $this->linkRepository->findOneBy(['key' => $key])?->getUrl();
    }
}

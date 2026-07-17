<?php

declare(strict_types=1);

namespace App\Twig;

use App\Repository\LinkRepository;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private readonly HtmlSanitizer $richTextSanitizer;

    public function __construct(private readonly LinkRepository $linkRepository)
    {
        $this->richTextSanitizer = new HtmlSanitizer((new HtmlSanitizerConfig())->allowSafeElements());
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('link_url', $this->getLinkUrl(...)),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('sanitize_html', $this->sanitizeHtml(...), ['is_safe' => ['html']]),
        ];
    }

    public function getLinkUrl(string $key): ?string
    {
        return $this->linkRepository->findOneBy(['key' => $key])?->getUrl();
    }

    public function sanitizeHtml(string $html): string
    {
        return $this->richTextSanitizer->sanitize($html);
    }
}

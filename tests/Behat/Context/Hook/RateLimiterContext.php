<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Hook;

use Behat\Behat\Context\Context;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class RateLimiterContext implements Context
{
    public function __construct(
        #[Autowire(service: 'cache.rate_limiter')]
        private CacheItemPoolInterface $rateLimiterCache,
    ) {
    }

    /**
     * @BeforeScenario
     */
    public function resetRateLimiters(): void
    {
        $this->rateLimiterCache->clear();
    }
}

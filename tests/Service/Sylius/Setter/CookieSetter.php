<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Service\Sylius\Setter;

use Behat\Mink\Session;
use FriendsOfBehat\SymfonyExtension\Driver\SymfonyDriver;
use Symfony\Component\BrowserKit\Cookie;

final class CookieSetter implements CookieSetterInterface
{
    /** @var array */
    private $minkParameters;

    public function __construct(private readonly Session $minkSession, $minkParameters)
    {
        if (!is_array($minkParameters) && !$minkParameters instanceof \ArrayAccess) {
            throw new \InvalidArgumentException(
                sprintf(
                    '"$minkParameters" passed to "%s" has to be an array or implement "%s".',
                    self::class,
                    \ArrayAccess::class
                )
            );
        }
        $this->minkParameters = $minkParameters;
    }

    public function setCookie($name, $value)
    {
        $driver = $this->minkSession->getDriver();

//        if ($driver instanceof ChromeDriver) {
//            if (!$driver->isStarted()) {
//                $driver->start();
//            }
//        }

        $this->prepareMinkSessionIfNeeded($this->minkSession);

        if ($driver instanceof SymfonyDriver) {
            $driver->getClient()->getCookieJar()->set(
                new Cookie($name, $value, null, null, parse_url((string) $this->minkParameters['base_url'], \PHP_URL_HOST))
            );

            return;
        }

        $this->minkSession->setCookie($name, $value);
    }

    private function prepareMinkSessionIfNeeded(Session $session): void
    {
        if ($this->shouldMinkSessionBePrepared($session)) {
            $session->visit(rtrim((string) $this->minkParameters['base_url'], '/').'/');
        }
    }

    private function shouldMinkSessionBePrepared(Session $session): bool
    {
        $driver = $session->getDriver();

        if ($driver instanceof SymfonyDriver) {
            return false;
        }

//        if ($driver instanceof Selenium2Driver && $driver->getWebDriverSession() === null) {
//            return true;
//        }
//
//        if ($driver instanceof ChromeDriver) {
//            return true;
//        }

        if (str_contains($session->getCurrentUrl(), (string) $this->minkParameters['base_url'])) {
            return false;
        }

        return true;
    }
}

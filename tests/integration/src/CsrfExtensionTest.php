<?php

declare(strict_types=1);

namespace Tests\Integration;

use Arachne\Codeception\Module\NetteDIModule;
use Arachne\Csrf\TokenStorage\SessionTokenStorage;
use Codeception\Test\Unit;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class CsrfExtensionTest extends Unit
{
    /**
     * @var NetteDIModule
     */
    protected $tester;

    public function testExtension(): void
    {
        self::assertInstanceOf(CsrfTokenManager::class, $this->tester->grabService(CsrfTokenManagerInterface::class));
        self::assertInstanceOf(UriSafeTokenGenerator::class, $this->tester->grabService(TokenGeneratorInterface::class));
        self::assertInstanceOf(SessionTokenStorage::class, $this->tester->grabService(TokenStorageInterface::class));
    }
}

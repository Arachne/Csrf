<?php

namespace Tests\Integration;

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
    public function testExtension()
    {
        $this->assertInstanceOf(CsrfTokenManager::class, $this->tester->grabService(CsrfTokenManagerInterface::class));
        $this->assertInstanceOf(UriSafeTokenGenerator::class, $this->tester->grabService(TokenGeneratorInterface::class));
        $this->assertInstanceOf(SessionTokenStorage::class, $this->tester->grabService(TokenStorageInterface::class));
    }
}

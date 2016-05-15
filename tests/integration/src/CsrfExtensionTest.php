<?php

namespace Tests\Integration;

use Arachne\Bootstrap\Configurator;
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
        $container = $this->createContainer('config.neon');

        $this->assertInstanceOf(CsrfTokenManager::class, $container->getByType(CsrfTokenManagerInterface::class));
        $this->assertInstanceOf(UriSafeTokenGenerator::class, $container->getByType(TokenGeneratorInterface::class));
        $this->assertInstanceOf(SessionTokenStorage::class, $container->getByType(TokenStorageInterface::class));
    }

    private function createContainer($file)
    {
        $config = new Configurator();
        $config->setTempDirectory(TEMP_DIR);
        $config->addConfig(__DIR__ . '/../config/' . $file);
        return $config->createContainer();
    }
}

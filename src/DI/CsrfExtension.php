<?php

declare(strict_types=1);

namespace Arachne\Csrf\DI;

use Arachne\Csrf\TokenStorage\SessionTokenStorage;
use Nette\DI\CompilerExtension;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class CsrfExtension extends CompilerExtension
{
    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('tokenManager'))
            ->setType(CsrfTokenManagerInterface::class)
            ->setFactory(CsrfTokenManager::class);

        $builder->addDefinition($this->prefix('tokenGenerator'))
            ->setType(TokenGeneratorInterface::class)
            ->setFactory(UriSafeTokenGenerator::class);

        $builder->addDefinition($this->prefix('tokenStorage'))
            ->setType(TokenStorageInterface::class)
            ->setFactory(SessionTokenStorage::class);
    }
}

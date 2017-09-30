<?php

declare(strict_types=1);

namespace Tests\Integration;

use Arachne\Codeception\Module\NetteDIModule;
use Arachne\Csrf\TokenStorage\SessionTokenStorage;
use Codeception\Test\Unit;
use Symfony\Component\Security\Csrf\Exception\TokenNotFoundException;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class SessionTokenStorageTest extends Unit
{
    /**
     * @var NetteDIModule
     */
    protected $tester;

    /**
     * @var SessionTokenStorage
     */
    private $storage;

    public function _before(): void
    {
        $this->storage = $this->tester->grabService(TokenStorageInterface::class);
    }

    public function testMethods(): void
    {
        $this->assertFalse($this->storage->hasToken('tokenId'));
        $this->storage->setToken('tokenId', 'tokenValue');
        $this->assertTrue($this->storage->hasToken('tokenId'));
        $this->assertSame('tokenValue', $this->storage->getToken('tokenId'));
        $this->assertTrue($this->storage->hasToken('tokenId'));
        $this->assertSame('tokenValue', $this->storage->removeToken('tokenId'));
        $this->assertFalse($this->storage->hasToken('tokenId'));
        $this->assertNull($this->storage->removeToken('tokenId'));
    }

    public function testException(): void
    {
        try {
            $this->storage->getToken('tokenId');
            $this->fail();
        } catch (TokenNotFoundException $exception) {
            self::assertSame('The CSRF token with ID "tokenId" does not exist.', $exception->getMessage());
        }
    }
}

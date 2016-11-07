<?php

namespace Tests\Integration;

use Arachne\Csrf\TokenStorage\SessionTokenStorage;
use Codeception\Test\Unit;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class SessionTokenStorageTest extends Unit
{
    /**
     * @var SessionTokenStorage
     */
    private $storage;

    public function _before()
    {
        $this->storage = $this->tester->grabService(TokenStorageInterface::class);
    }

    public function testMethods()
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

    /**
     * @expectedException \Symfony\Component\Security\Csrf\Exception\TokenNotFoundException
     * @expectedExceptionMessage The CSRF token with ID 'tokenId' does not exist.
     */
    public function testException()
    {
        $this->storage->getToken('tokenId');
    }
}

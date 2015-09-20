<?php
/**
 * This file is part of Token\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Token\JWT\Claim;

/**
 * @author Luís Otávio Cobucci Oblonczyk <token@gmail.com>
 * @since 2.0.0
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @covers Token\JWT\Claim\Factory::__construct
     */
    public function constructMustConfigureTheCallbacks()
    {
        $callback = function () {
        };
        $factory = new Factory(['test' => $callback]);

        $expected = [
            'iat' => [$factory, 'createLesserOrEqualsTo'],
            'nbf' => [$factory, 'createLesserOrEqualsTo'],
            'exp' => [$factory, 'createGreaterOrEqualsTo'],
            'iss' => [$factory, 'createEqualsTo'],
            'aud' => [$factory, 'createEqualsTo'],
            'sub' => [$factory, 'createEqualsTo'],
            'jti' => [$factory, 'createEqualsTo'],
            'test' => $callback
        ];

        $this->assertAttributeEquals($expected, 'callbacks', $factory);
    }

    /**
     * @test
     *
     * @uses Token\JWT\Claim\Factory::__construct
     * @uses Token\JWT\Claim\Basic::__construct
     *
     * @covers Token\JWT\Claim\Factory::create
     * @covers Token\JWT\Claim\Factory::createLesserOrEqualsTo
     */
    public function createShouldReturnALesserOrEqualsToClaimForIssuedAt()
    {
        $claim = new Factory();

        $this->assertInstanceOf(LesserOrEqualsTo::class, $claim->create('iat', 1));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Claim\Factory::__construct
     * @uses Token\JWT\Claim\Basic::__construct
     *
     * @covers Token\JWT\Claim\Factory::create
     * @covers Token\JWT\Claim\Factory::createLesserOrEqualsTo
     */
    public function createShouldReturnALesserOrEqualsToClaimForNotBefore()
    {
        $claim = new Factory();

        $this->assertInstanceOf(LesserOrEqualsTo::class, $claim->create('nbf', 1));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Claim\Factory::__construct
     * @uses Token\JWT\Claim\Basic::__construct
     *
     * @covers Token\JWT\Claim\Factory::create
     * @covers Token\JWT\Claim\Factory::createGreaterOrEqualsTo
     */
    public function createShouldReturnAGreaterOrEqualsToClaimForExpiration()
    {
        $claim = new Factory();

        $this->assertInstanceOf(GreaterOrEqualsTo::class, $claim->create('exp', 1));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Claim\Factory::__construct
     * @uses Token\JWT\Claim\Basic::__construct
     *
     * @covers Token\JWT\Claim\Factory::create
     * @covers Token\JWT\Claim\Factory::createEqualsTo
     */
    public function createShouldReturnAnEqualsToClaimForId()
    {
        $claim = new Factory();

        $this->assertInstanceOf(EqualsTo::class, $claim->create('jti', 1));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Claim\Factory::__construct
     * @uses Token\JWT\Claim\Basic::__construct
     *
     * @covers Token\JWT\Claim\Factory::create
     * @covers Token\JWT\Claim\Factory::createEqualsTo
     */
    public function createShouldReturnAnEqualsToClaimForIssuer()
    {
        $claim = new Factory();

        $this->assertInstanceOf(EqualsTo::class, $claim->create('iss', 1));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Claim\Factory::__construct
     * @uses Token\JWT\Claim\Basic::__construct
     *
     * @covers Token\JWT\Claim\Factory::create
     * @covers Token\JWT\Claim\Factory::createEqualsTo
     */
    public function createShouldReturnAnEqualsToClaimForAudience()
    {
        $claim = new Factory();

        $this->assertInstanceOf(EqualsTo::class, $claim->create('aud', 1));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Claim\Factory::__construct
     * @uses Token\JWT\Claim\Basic::__construct
     *
     * @covers Token\JWT\Claim\Factory::create
     * @covers Token\JWT\Claim\Factory::createEqualsTo
     */
    public function createShouldReturnAnEqualsToClaimForSubject()
    {
        $claim = new Factory();

        $this->assertInstanceOf(EqualsTo::class, $claim->create('sub', 1));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Claim\Factory::__construct
     * @uses Token\JWT\Claim\Basic::__construct
     *
     * @covers Token\JWT\Claim\Factory::create
     * @covers Token\JWT\Claim\Factory::createBasic
     */
    public function createShouldReturnABasiclaimForOtherClaims()
    {
        $claim = new Factory();

        $this->assertInstanceOf(Basic::class, $claim->create('test', 1));
    }
}

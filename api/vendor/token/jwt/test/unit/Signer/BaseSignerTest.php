<?php
/**
 * This file is part of Token\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Token\JWT\Signer;

use Token\JWT\Signature;

/**
 * @author Luís Otávio Cobucci Oblonczyk <token@gmail.com>
 * @since 0.1.0
 */
class BaseSignerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BaseSigner|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $signer;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->signer = $this->getMockForAbstractClass(BaseSigner::class);

        $this->signer->method('getAlgorithmId')
                     ->willReturn('TEST123');
    }

    /**
     * @test
     *
     * @covers Token\JWT\Signer\BaseSigner::modifyHeader
     */
    public function modifyHeaderShouldChangeAlgorithmAndType()
    {
        $headers = [];

        $this->signer->modifyHeader($headers);

        $this->assertEquals($headers['typ'], 'JWS');
        $this->assertEquals($headers['alg'], 'TEST123');
    }

    /**
     * @test
     *
     * @uses Token\JWT\Signature::__construct
     * @uses Token\JWT\Signer\Key
     *
     * @covers Token\JWT\Signer\BaseSigner::sign
     * @covers Token\JWT\Signer\BaseSigner::getKey
     */
    public function signMustReturnANewSignature()
    {
        $key = new Key('123');

        $this->signer->expects($this->once())
                     ->method('createHash')
                     ->with('test', $key)
                     ->willReturn('test');

        $this->assertEquals(new Signature('test'), $this->signer->sign('test', $key));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Signature::__construct
     * @uses Token\JWT\Signer\Key
     *
     * @covers Token\JWT\Signer\BaseSigner::sign
     * @covers Token\JWT\Signer\BaseSigner::getKey
     */
    public function signShouldConvertKeyWhenItsNotAnObject()
    {
        $this->signer->expects($this->once())
                     ->method('createHash')
                     ->with('test', new Key('123'))
                     ->willReturn('test');

        $this->assertEquals(new Signature('test'), $this->signer->sign('test', '123'));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Signature::__construct
     * @uses Token\JWT\Signer\Key
     *
     * @covers Token\JWT\Signer\BaseSigner::verify
     * @covers Token\JWT\Signer\BaseSigner::getKey
     */
    public function verifyShouldDelegateTheCallToAbstractMethod()
    {
        $key = new Key('123');

        $this->signer->expects($this->once())
                     ->method('doVerify')
                     ->with('test', 'test', $key)
                     ->willReturn(true);

        $this->assertTrue($this->signer->verify('test', 'test', $key));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Signature::__construct
     * @uses Token\JWT\Signer\Key
     *
     * @covers Token\JWT\Signer\BaseSigner::verify
     * @covers Token\JWT\Signer\BaseSigner::getKey
     */
    public function verifyShouldConvertKeyWhenItsNotAnObject()
    {
        $this->signer->expects($this->once())
                     ->method('doVerify')
                     ->with('test', 'test', new Key('123'))
                     ->willReturn(true);

        $this->assertTrue($this->signer->verify('test', 'test', '123'));
    }
}

<?php
/**
 * This file is part of Token\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Token\JWT\FunctionalTests;

use Token\JWT\Builder;
use Token\JWT\Parser;
use Token\JWT\Token;
use Token\JWT\Signature;
use Token\JWT\Signer\Hmac\Sha256;
use Token\JWT\Signer\Hmac\Sha512;

/**
 * @author Luís Otávio Cobucci Oblonczyk <token@gmail.com>
 * @since 2.1.0
 */
class HmacTokenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Sha256
     */
    private $signer;

    /**
     * @before
     */
    public function createSigner()
    {
        $this->signer = new Sha256();
    }

    /**
     * @test
     *
     * @covers Token\JWT\Builder
     * @covers Token\JWT\Token
     * @covers Token\JWT\Signature
     * @covers Token\JWT\Claim\Factory
     * @covers Token\JWT\Claim\Basic
     * @covers Token\JWT\Parsing\Encoder
     * @covers Token\JWT\Signer\Key
     * @covers Token\JWT\Signer\BaseSigner
     * @covers Token\JWT\Signer\Hmac
     * @covers Token\JWT\Signer\Hmac\Sha256
     */
    public function builderCanGenerateAToken()
    {
        $user = (object) ['name' => 'testing', 'email' => 'testing@abc.com'];

        $token = (new Builder())->setId(1)
                              ->setAudience('http://client.abc.com')
                              ->setIssuer('http://api.abc.com')
                              ->set('user', $user)
                              ->sign($this->signer, 'testing')
                              ->getToken();

        $this->assertAttributeInstanceOf(Signature::class, 'signature', $token);
        $this->assertEquals('http://client.abc.com', $token->getClaim('aud'));
        $this->assertEquals('http://api.abc.com', $token->getClaim('iss'));
        $this->assertEquals($user, $token->getClaim('user'));

        return $token;
    }

    /**
     * @test
     *
     * @depends builderCanGenerateAToken
     *
     * @covers Token\JWT\Builder
     * @covers Token\JWT\Parser
     * @covers Token\JWT\Token
     * @covers Token\JWT\Signature
     * @covers Token\JWT\Claim\Factory
     * @covers Token\JWT\Claim\Basic
     * @covers Token\JWT\Parsing\Encoder
     * @covers Token\JWT\Parsing\Decoder
     */
    public function parserCanReadAToken(Token $generated)
    {
        $read = (new Parser())->parse((string) $generated);

        $this->assertEquals($generated, $read);
        $this->assertEquals('testing', $read->getClaim('user')->name);
    }

    /**
     * @test
     *
     * @depends builderCanGenerateAToken
     *
     * @covers Token\JWT\Builder
     * @covers Token\JWT\Parser
     * @covers Token\JWT\Token
     * @covers Token\JWT\Signature
     * @covers Token\JWT\Parsing\Encoder
     * @covers Token\JWT\Claim\Factory
     * @covers Token\JWT\Claim\Basic
     * @covers Token\JWT\Signer\Key
     * @covers Token\JWT\Signer\BaseSigner
     * @covers Token\JWT\Signer\Hmac
     * @covers Token\JWT\Signer\Hmac\Sha256
     */
    public function verifyShouldReturnFalseWhenKeyIsNotRight(Token $token)
    {
        $this->assertFalse($token->verify($this->signer, 'testing1'));
    }

    /**
     * @test
     *
     * @depends builderCanGenerateAToken
     *
     * @covers Token\JWT\Builder
     * @covers Token\JWT\Parser
     * @covers Token\JWT\Token
     * @covers Token\JWT\Signature
     * @covers Token\JWT\Parsing\Encoder
     * @covers Token\JWT\Claim\Factory
     * @covers Token\JWT\Claim\Basic
     * @covers Token\JWT\Signer\Key
     * @covers Token\JWT\Signer\BaseSigner
     * @covers Token\JWT\Signer\Hmac
     * @covers Token\JWT\Signer\Hmac\Sha256
     * @covers Token\JWT\Signer\Hmac\Sha512
     */
    public function verifyShouldReturnFalseWhenAlgorithmIsDifferent(Token $token)
    {
        $this->assertFalse($token->verify(new Sha512(), 'testing'));
    }

    /**
     * @test
     *
     * @depends builderCanGenerateAToken
     *
     * @covers Token\JWT\Builder
     * @covers Token\JWT\Parser
     * @covers Token\JWT\Token
     * @covers Token\JWT\Signature
     * @covers Token\JWT\Parsing\Encoder
     * @covers Token\JWT\Claim\Factory
     * @covers Token\JWT\Claim\Basic
     * @covers Token\JWT\Signer\Key
     * @covers Token\JWT\Signer\BaseSigner
     * @covers Token\JWT\Signer\Hmac
     * @covers Token\JWT\Signer\Hmac\Sha256
     */
    public function verifyShouldReturnTrueWhenKeyIsRight(Token $token)
    {
        $this->assertTrue($token->verify($this->signer, 'testing'));
    }

    /**
     * @test
     *
     * @covers Token\JWT\Builder
     * @covers Token\JWT\Parser
     * @covers Token\JWT\Token
     * @covers Token\JWT\Signature
     * @covers Token\JWT\Signer\Key
     * @covers Token\JWT\Signer\BaseSigner
     * @covers Token\JWT\Signer\Hmac
     * @covers Token\JWT\Signer\Hmac\Sha256
     * @covers Token\JWT\Claim\Factory
     * @covers Token\JWT\Claim\Basic
     * @covers Token\JWT\Parsing\Encoder
     * @covers Token\JWT\Parsing\Decoder
     */
    public function everythingShouldWorkWhenUsingATokenGeneratedByOtherLibs()
    {
        $data = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXUyJ9.eyJoZWxsbyI6IndvcmxkIn0.Rh'
                . '7AEgqCB7zae1PkgIlvOpeyw9Ab8NGTbeOH7heHO0o';

        $token = (new Parser())->parse((string) $data);

        $this->assertEquals('world', $token->getClaim('hello'));
        $this->assertTrue($token->verify($this->signer, 'testing'));
    }
}

<?php
/**
 * This file is part of Token\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Token\JWT\Signer\Ecdsa;

/**
 * @author Luís Otávio Cobucci Oblonczyk <token@gmail.com>
 * @since 2.1.0
 */
class Sha512Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @uses Token\JWT\Signer\Ecdsa
     * @uses Token\JWT\Signer\Ecdsa\KeyParser
     *
     * @covers Token\JWT\Signer\Ecdsa\Sha512::getAlgorithmId
     */
    public function getAlgorithmIdMustBeCorrect()
    {
        $signer = new Sha512();

        $this->assertEquals('ES512', $signer->getAlgorithmId());
    }

    /**
     * @test
     *
     * @uses Token\JWT\Signer\Ecdsa
     * @uses Token\JWT\Signer\Ecdsa\KeyParser
     *
     * @covers Token\JWT\Signer\Ecdsa\Sha512::getAlgorithm
     */
    public function getAlgorithmMustBeCorrect()
    {
        $signer = new Sha512();

        $this->assertEquals('sha512', $signer->getAlgorithm());
    }

    /**
     * @test
     *
     * @uses Token\JWT\Signer\Ecdsa
     * @uses Token\JWT\Signer\Ecdsa\KeyParser
     *
     * @covers Token\JWT\Signer\Ecdsa\Sha512::getSignatureLength
     */
    public function getSignatureLengthMustBeCorrect()
    {
        $signer = new Sha512();

        $this->assertEquals(132, $signer->getSignatureLength());
    }
}

<?php
/**
 * This file is part of Token\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Token\JWT\Signer\Rsa;

use Token\JWT\Signer\Rsa;

/**
 * Signer for RSA SHA-512
 *
 * @author Luís Otávio Cobucci Oblonczyk <token@gmail.com>
 * @since 2.1.0
 */
class Sha512 extends Rsa
{
    /**
     * {@inheritdoc}
     */
    public function getAlgorithmId()
    {
        return 'RS512';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithm()
    {
        return OPENSSL_ALGO_SHA512;
    }
}

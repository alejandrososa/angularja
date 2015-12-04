<?php
/**
 * This file is part of Token\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Token\JWT\Signer\Hmac;

use Token\JWT\Signer\Hmac;

/**
 * Signer for HMAC SHA-512
 *
 * @author Luís Otávio Cobucci Oblonczyk <token@gmail.com>
 * @since 0.1.0
 */
class Sha512 extends Hmac
{
    /**
     * {@inheritdoc}
     */
    public function getAlgorithmId()
    {
        return 'HS512';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithm()
    {
        return 'sha512';
    }
}

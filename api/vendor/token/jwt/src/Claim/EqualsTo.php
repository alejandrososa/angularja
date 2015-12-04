<?php
/**
 * This file is part of Token\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Token\JWT\Claim;

use Token\JWT\Claim;
use Token\JWT\ValidationData;

/**
 * Validatable claim that checks if value is strictly equals to the given data
 *
 * @author Luís Otávio Cobucci Oblonczyk <token@gmail.com>
 * @since 2.0.0
 */
class EqualsTo extends Basic implements Claim, Validatable
{
    /**
     * {@inheritdoc}
     */
    public function validate(ValidationData $data)
    {
        if ($data->has($this->getName())) {
            return $this->getValue() === $data->get($this->getName());
        }

        return true;
    }
}

<?php
/**
 * This file is part of Token\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Token\JWT\Claim;

use Token\JWT\ValidationData;

/**
 * @author Luís Otávio Cobucci Oblonczyk <token@gmail.com>
 * @since 2.0.0
 */
class EqualsToTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @uses Token\JWT\Claim\Basic::__construct
     * @uses Token\JWT\Claim\Basic::getName
     * @uses Token\JWT\ValidationData::__construct
     * @uses Token\JWT\ValidationData::has
     *
     * @covers Token\JWT\Claim\EqualsTo::validate
     */
    public function validateShouldReturnTrueWhenValidationDontHaveTheClaim()
    {
        $claim = new EqualsTo('iss', 'test');

        $this->assertTrue($claim->validate(new ValidationData()));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Claim\Basic::__construct
     * @uses Token\JWT\Claim\Basic::getName
     * @uses Token\JWT\Claim\Basic::getValue
     * @uses Token\JWT\ValidationData::__construct
     * @uses Token\JWT\ValidationData::setIssuer
     * @uses Token\JWT\ValidationData::has
     * @uses Token\JWT\ValidationData::get
     *
     * @covers Token\JWT\Claim\EqualsTo::validate
     */
    public function validateShouldReturnTrueWhenValueIsEqualsToValidationData()
    {
        $claim = new EqualsTo('iss', 'test');

        $data = new ValidationData();
        $data->setIssuer('test');

        $this->assertTrue($claim->validate($data));
    }

    /**
     * @test
     *
     * @uses Token\JWT\Claim\Basic::__construct
     * @uses Token\JWT\Claim\Basic::getName
     * @uses Token\JWT\Claim\Basic::getValue
     * @uses Token\JWT\ValidationData::__construct
     * @uses Token\JWT\ValidationData::setIssuer
     * @uses Token\JWT\ValidationData::has
     * @uses Token\JWT\ValidationData::get
     *
     * @covers Token\JWT\Claim\EqualsTo::validate
     */
    public function validateShouldReturnFalseWhenValueIsNotEqualsToValidationData()
    {
        $claim = new EqualsTo('iss', 'test');

        $data = new ValidationData();
        $data->setIssuer('test1');

        $this->assertFalse($claim->validate($data));
    }
}

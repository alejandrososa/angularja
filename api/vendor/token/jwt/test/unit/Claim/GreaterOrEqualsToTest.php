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
class GreaterOrEqualsToTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @uses Token\JWT\Claim\Basic::__construct
     * @uses Token\JWT\Claim\Basic::getName
     * @uses Token\JWT\ValidationData::__construct
     * @uses Token\JWT\ValidationData::has
     *
     * @covers Token\JWT\Claim\GreaterOrEqualsTo::validate
     */
    public function validateShouldReturnTrueWhenValidationDontHaveTheClaim()
    {
        $claim = new GreaterOrEqualsTo('iss', 10);

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
     * @covers Token\JWT\Claim\GreaterOrEqualsTo::validate
     */
    public function validateShouldReturnTrueWhenValueIsGreaterThanValidationData()
    {
        $claim = new GreaterOrEqualsTo('iss', 11);

        $data = new ValidationData();
        $data->setIssuer(10);

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
     * @covers Token\JWT\Claim\GreaterOrEqualsTo::validate
     */
    public function validateShouldReturnTrueWhenValueIsEqualsToValidationData()
    {
        $claim = new GreaterOrEqualsTo('iss', 10);

        $data = new ValidationData();
        $data->setIssuer(10);

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
     * @covers Token\JWT\Claim\GreaterOrEqualsTo::validate
     */
    public function validateShouldReturnFalseWhenValueIsLesserThanValidationData()
    {
        $claim = new GreaterOrEqualsTo('iss', 10);

        $data = new ValidationData();
        $data->setIssuer(11);

        $this->assertFalse($claim->validate($data));
    }
}

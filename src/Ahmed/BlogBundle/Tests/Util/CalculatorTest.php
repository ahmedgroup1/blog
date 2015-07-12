<?php

// src/AppBundle/Tests/Util/CalculatorTest.php
namespace Ahmed\BlogBundle\Tests\Util;

use Ahmed\BlogBundle\Util\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $calc = new Calculator();
        $result = $calc->add(30,12);
        $this->assertEquals(41,$result);
    }
}

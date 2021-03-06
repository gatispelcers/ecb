<?php

use Raccoon\Ecb\Bank;

class BankTest extends PHPUnit_Framework_TestCase
{
    /**
     * Setup
     */
    public function setUp()
    {
        $this->bank = new Bank();
    }

    /**
     * Test rates can be set correctly
     */
    public function testRatesCanBeSetCorrectly()
    {
        $rates = array('USD' => 1.1111, 'ZAR' => 15.0111);
        $this->bank->setRates($rates);

        $this->assertEquals($rates, $this->bank->toArray());
    }

    /**
     * Test Rates can be cast to stdObject
     */
    public function testRatesCanBeCastToStdClass()
    {
        $rates = array('USD' => 1.1111, 'ZAR' => 15.0111);
        $this->bank->setRates($rates);
        $ratesToObject = $this->bank->toObject();

        $this->assertInstanceOf('stdClass', $ratesToObject);
        $this->assertObjectHasAttribute('USD', $ratesToObject);
        $this->assertEquals(1.1111, $ratesToObject->USD);
    }
    
    /**
     * Test correct JSON is returned
     */
    public function testRatesCanBeCastToJson()
    {
        $rates = array('USD' => 1.1111, 'ZAR' => 15.0111);
        $this->bank->setRates($rates);

        $this->assertEquals('{"USD":1.1111,"ZAR":15.0111}', $this->bank->toJson());
    }

    /**
     * Test correct CSV ir returned
     */
    public function testRatesCanBeCastToCSV()
    {
        $rates = array('USD' => 1.1111, 'ZAR' => 15.0111);
        $this->bank->setRates($rates);

        $this->assertEquals("USD;ZAR\r\n1.1111;15.0111\r\n", $this->bank->toCsv(';'));
        //default delimiter is ','
        $this->assertEquals("USD,ZAR\r\n1.1111,15.0111\r\n", $this->bank->toCsv());
    }

    /**
     * Test Single Rate is returned correctly
     */
    public function testSingleRateIsReturnedCorrectly()
    {
        $rates = array('USD' => 1.1111, 'ZAR' => 15.0111);
        $this->bank->setRates($rates);

        $this->assertEquals(1.1111, $this->bank->getRate('USD'));
    }

    /**
     * Test Exception Is Thrown if non-existent rate is required
     * @expectedException Raccoon\Ecb\Exceptions\InvalidCurrencyException
     */
    public function testExceptionIsThrownForNonExistentRate()
    {
        $rates = array('USD' => 1.1111, 'ZAR' => 15.0111);
        $this->bank->setRates($rates);
        $this->bank->getRate('LOL');
    }

    /**
     * Test Rates are loaded correctly
     */
    public function testRatesAreLoadedCorrectly()
    {
        $rates = array('USD' => 1.1111, 'ZAR' => 15.0111);
        $loader = $this->getMockBuilder('Raccoon\Ecb\XMLLoader')
                    ->setMethods(array('load'))
                    ->getMock();

        $loader->expects($this->once())
            ->method('load')
            ->will($this->returnValue($rates));

        $this->bank->setLoader($loader);

        $this->assertEquals($rates, $this->bank->loadRates()->toArray());
    }
}

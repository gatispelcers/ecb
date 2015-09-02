<?php

use Pelcers\Ecb\XMLLoader;

class XMLLoaderest extends PHPUnit_Framework_TestCase
{
    /**
     * Setup
     */
    public function setUp()
    {
        $this->loader = new XMLLoader();
    }

    /**
     * Test for correct XML parse
     */
    public function testXmlGetsParsedCorrectly()
    {
        $xml = simplexml_load_file('tests/sampleData.xml');

        $rates = $this->loader->parse($xml);

        $this->assertArrayHasKey('USD', $rates);
    }

}

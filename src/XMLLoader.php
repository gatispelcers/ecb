<?php
namespace Raccoon\Ecb;

use Raccoon\Ecb\Exceptions\InvalidEndPointException;

class XMLLoader implements Loader
{
    /**
     * @var string
     */
    protected $endPoint = "https://www.bank.lv/vk/ecb.xml";

    /**
     * Load xml data
     * @return array
     */
    public function load()
    {
        $xml = simplexml_load_file($this->endPoint);
        if (!$xml)
            throw new InvalidEndPointException("Endpoint '" . $this->endPoint . "' does not return valid xml");
            
        return $this->parse($xml);
    }

    /**
     * Parse XML to array
     * @param $xml - SimpleXMLElement
     * @return array
     */
    private function parse($xml)
    {
        $rates = array();
        foreach ($xml->Currencies->Currency as $key => $currency) {
            $rates[(string)$currency->ID] = (float)$currency->Rate;
        }

        return $rates;
    }
}

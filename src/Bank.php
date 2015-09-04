<?php
namespace Raccoon\Ecb;

use Raccoon\Ecb\Exceptions\InvalidCurrencyException;
use Raccoon\Ecb\Loader;

/**
* Bank
*/
class Bank
{
    /**
     * @var loader
     */
    protected $loader;

    /**
     * @var rates
     */
    protected $rates = array();

    /**
     * Set Loader
     * @param $loader - Raccoon\Ecb\Loader
     * @return Raccoon\Ecb\Bank
     */
    public function setLoader(Loader $loader)
    {
        $this->loader = $loader;
        return $this;
    }

    /**
     * Load currency rates
     * @return Raccoon\Ecb\Bank
     */
    public function loadRates()
    {
        $this->setRates($this->loader->load());
        return $this;
    }

    /**
     * Set currency rates
     * @param $rates - array
     * @return void
     */
    public function setRates(array $rates)
    {
        $this->rates = $rates;
    }

    /**
     * Get rate for single currency
     * @param $currency - string currency code
     * @throws Raccoon\Ecb\Exceptions\InvalidCurrencyException
     * @return float
     */
    public function getRate($currency)
    {
        if (!isset($this->rates[$currency]))
            throw new InvalidCurrencyException("The currency '$currency' does not exist!");
            
        return $this->rates[$currency];
    }


    /**
     * All currency rates in array
     * @return array
     */
    public function toArray()
    {
        return $this->rates;
    }

    /**
     * All curency rates as stdClass object
     * @return stdClass
     */
    public function toObject()
    {
        return (object)$this->rates;
    }

    /**
     * All curency rates JSON encoded
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->rates);
    }

    /**
     * All curency rates CSV encoded
     * @param $delimiter - string csv delimiting symbol
     * @return string
     */
    public function toCsv($delimiter = ",")
    {
        $line1 = '';
        $line2 = '';
        foreach ($this->rates as $code => $rate) {
            $line1 .= $code . $delimiter;
            $line2 .= $rate . $delimiter;
        }
        $line1 = rtrim($line1, $delimiter) . "\r\n";
        $line2 = rtrim($line2, $delimiter). "\r\n";
        return $line1 . $line2;
    }
}

<?php
namespace Pelcers\Ecb;

use Pelcers\Ecb\Exceptions\InvalidCurrencyException;
use Pelcers\Ecb\Loader;
use Pelcers\Ecb\XMLLoader;

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
     * Construct
     */
    public function __construct()
    {
        $this->loader = new XMLLoader();
    }

    /**
     * Set Loader
     * @param $loader - Pelcers\Ecb\Loader
     * @return void
     */
    public function setLoader(Loader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Load currency rates
     * @return Pelcers\Ecb\Bank
     */
    public function loadRates()
    {
        $this->setRates($this->loader->load());
        return $this;
    }

    /**
     * Rates Setter
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
     * @throws Pelcers\Ecb\Exceptions\InvalidCurrencyException
     * @return float
     */
    public function getRate($currency)
    {
        if (!isset($this->rates[$currency])) {
            throw new InvalidCurrencyException("The currency '$currency' does not exist!");
        }
            
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
}

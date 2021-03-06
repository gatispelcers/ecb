# PHP Wrapper for Euro foreign exchange reference rates published by the European Central Bank in XML format 

This is a simple PHP wrapper for Euro exchange rates published by ECB. More information about XML endpoint:
[https://www.bank.lv/en/component/content/article/8791](https://www.bank.lv/en/component/content/article/8791)

## Disclaimer

Warning: Code has unit test coverage (not full!) and as far as I can tell is functional at the time of this writing. But if you decide to use my code, please, do it at your own risk. This is me learning some OO PHP. 

## Sample usage

Clone this repo. Run "composer install".

```php
require_once "vendor/autoload.php";

$bank = new Raccoon\Ecb\Bank();
/**
 * Set Loader. You can create your own Loader class(for more info please refer to
 * Raccoon\Ecb\XMLLoader class).
 * You have to implement Raccoon\Ecb\Loader interface 
 */
$bank->setLoader(new Raccoon\Ecb\XMLLoader());

/**
 * Load currency rates. Call to https://www.bank.lv/vk/ecb.xml is made. 
 * If for some reason call will be unsuccessful (Endpoint down, invalid xml, etc.) an
 * Raccoon\Ecb\Exceptions\InvalidEndPointException will be thrown
 */
$bank->loadRates();

/**
 * Get single currency rate. If currency rate does not exist an  
 * Raccoon\Ecb\Exceptions\InvalidCurrencyException will be thrown
 */
echo $bank->getRate('USD');

// Cast all currency rates to valid JSON string
echo $bank->toJson();

/**
 * Cast all currency rates to CSV string.
 * First parameter is used as CSV string delimiter
 */
echo $bank->toCsv(";");

// All currency rates to array;
print_r($bank->toArray());

// Cast all currency rates to stdClass Object
print_r($bank->toObject());

```

## Additional info

Use caching mechanism of your choice to speed things up.


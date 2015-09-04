# ecb
PHP Wrapper for Bank of Latvia xml euro currency rate API. If you decide to use this please do it at your own risk. This is me learning some OO PHP. 

# Sample usage

require_once "vendor/autoload.php";

$bank = new Raccoon\Ecb\Bank();

// Set Loader. You can create your own Loader class. You have to implement Raccoon\Ecb\Loader interface
$bank->setLoader(new Raccoon\Ecb\XMLLoader());

// Load currency rates. Call to https://www.bank.lv/vk/ecb.xml is made. If for some reason call will be unsuccessful (Endpoint down, invalid xml, etc.) an Raccoon\Ecb\Exceptions\InvalidEndPointException will be thrown
$bank->loadRates();

// Get single currency rate. If currency rate does not exist an Raccoon\Ecb\Exceptions\InvalidCurrencyException will be thrown
echo $bank->getRate('USD');

// Cast all currency rates to valid JSON string
echo $bank->toJson();

//Cast all currency rates to CSV string. First parameter is CSV string delimiter
echo $bank->toCsv(";");

// All currency rates to array;
print_r($bank->toArray());

// Cast all currency rates to stdClass Object
print_r($bank->toObject());

Use caching mechanism of your choice. 

More information about endpoint:
https://www.bank.lv/en/component/content/article/8791
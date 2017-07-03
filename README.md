# MIEP Public API Client

## Check codestyle

`make codestyle`

## Run tests

`make tests`

## Using the library

```php 
use MaxImmo\ExternalParties\MiepClient;
use MaxImmo\ExternalParties\Client;
use MaxImmo\ExternalParties\JsonResponseEvaluator;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;

$httpClient = new HttpClient(); // Implementation of Interface
$messageFactory =  new MessageFactory(); // Implementation of Interface
$responseEvaluator = new JsonResponseEvaluator();
$apiClient = new Client($httpClient, $messageFactory, $responseEvaluator);
$miepClient = new MiepClient('client_id', 'client_secret', $apiClient);
```

More info: http://docs.php-http.org/en/latest/index.html

### Get list of available Brokers

```php
$miepClient->getBrokers();
```

### Get information for given Broker

```php
$miepClient->getInformationForBroker('brokerId');
```

Note: Broker ID is the sub-domain of the broker's MaxImmo URL. This Broker ID will be provided in the list of available brokers discussed earlier.


### Get Real Estate for Broker

```php
$miepClient->getRealEstateListForBroker('brokerId');
```

Note: Broker ID is the sub-domain of the broker's MaxImmo URL. This Broker ID will be provided in the list of available brokers discussed earlier.

### Get property for Broker

```php
$miepClient->getPropertyForBroker('brokerId', 'propertyId');
```

Note: 

- brokerId is the sub-domain of the broker's MaxImmo URL. This Broker ID will be provided in the list of available brokers discussed earlier.
- propertyId is the Max-immo property id. This Property ID will be provided in the list of available Real Estate discussed earlier. 

### Get project for broker

```php
$miepClient->getProjectForBroker('brokerId', 'projectId');
```
Note: 

- brokerId is the sub-domain of the broker's MaxImmo URL. This Broker ID will be provided in the list of available brokers discussed earlier.
- projectId is the Max-immo property id. This Project ID will be provided in the list of available Real Estate discussed earlier. 

## Versioning

This library will follow the classic [semver versioning](http://semver.org/). The master branch will always follow the latest release.

Changes on the core of this library and added features, will be merged back to previous versions on a best effort basis.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
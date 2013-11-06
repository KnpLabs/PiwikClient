PiwikClient
===========

PHP 5.3 client for [Piwik](http://piwik.org/) web analytics.

To see all available methods & their parameters, visit [Piwik API Reference](http://piwik.org/docs/analytics-api/reference/).


Usage
-----

### Through HTTP connection

```php
use Knp\PiwikClient\Connection\HttpConnection;
use Knp\PiwikClient\Client;

// Instantiate piwik client
$connection = new HttpConnection('http://demo.piwik.org');
$client = new Client($connection, 'YOUR_API_TOKEN');

// Call piwik API
$array = $client->call('PLUGIN.METHOD', $parameters);
```

### Through local (PHP) connection

```php
use Knp\PiwikClient\Connection\PiwikConnection;
use Knp\PiwikClient\Client;

// Instantiate piwik
require_once PIWIK_INCLUDE_PATH . "/index.php";
require_once PIWIK_INCLUDE_PATH . "/core/API/Request.php";
Piwik_FrontController::getInstance()->init();

// Instantiate piwik client
$connection = new PiwikConnection();
$client = new Client($connection, 'YOUR_API_TOKEN');

// Call piwik API
$array = $client->call('PLUGIN.METHOD', $parameters);
```


Installation
---------

This library can be installed using composer by adding the following in the require section of your composer.json file:

```json
"require": {
        ...
        "knplabs/knp-piwik-client": "dev-master"
},
```


Copyright
---------
PiwikClient is released under the MIT License. See the bundled LICENSE file for details.

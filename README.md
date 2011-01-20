PiwikClient
===========

PHP 5.3 client for [Piwik](http://piwik.org/) web analytics.

Usage
-----

1. Through HTTP connection:
        <?php
        
        $connection = new Knplabs\PiwikClient\Connection\HttpConnection('http://demo.piwik.org');
        $client     = new Knplabs\PiwikClient\Client($connection, 'YOUR_API_TOKEN');
        
        $array = $client->call('API.getReportMetadata', array('idSites' => array(23, 55)));
2. Through local (PHP) connection:
        <?php

        require_once PIWIK_INCLUDE_PATH . "/index.php";
        require_once PIWIK_INCLUDE_PATH . "/core/API/Request.php";
        Piwik_FrontController::getInstance()->init();

        $connection = new Knplabs\PiwikClient\Connection\PiwikConnection();
        $client     = new Knplabs\PiwikClient\Client($connection, 'YOUR_API_TOKEN');

        $array = $client->call('API.getReportMetadata', array('idSites' => array(23, 55)));

Methods
-------

For all available methods & attributes, visit [Piwik API Reference](http://dev.piwik.org/trac/wiki/API/Reference).

Copyright
---------

PiwikClient Copyright (c) 2011 knpLabs <http://www.knplabs.com>. See LICENSE for details.

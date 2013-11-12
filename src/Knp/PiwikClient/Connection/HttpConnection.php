<?php

/*
 * This file is part of the PiwikClient.
 * (c) 2013 Knp Labs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Knp\PiwikClient\Connection;

use Knp\PiwikClient\Exception\Exception as PiwikException;
use Buzz\Browser,
    Buzz\Client\Curl;

/**
 * Piwik HTTP Connector.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class HttpConnection extends PiwikConnection
{
    private $browser;
    private $apiUrl;

    /**
     * Initialize client.
     *
     * @param   string  $apiUrl     base API URL
     * @param   Browser $browser    Buzz Browser instance (optional)
     */
    public function __construct($apiUrl, Browser $browser = null)
    {
        if (null === $browser) {
            $this->browser = new Browser(new Curl());
        } else {
            $this->browser = $browser;
        }

        $this->apiUrl = $apiUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function send(array $params = array())
    {
        $params['module'] = 'API';

        $url = $this->apiUrl . '?' . $this->convertParamsToQuery($params);

        $response =  $this->browser->get($url);
        if(!$response->isSuccessful()) {
            throw new PiwikException(sprintf('"%s" returned an invalid status code: "%s"', $url, $response->getStatusCode()));
        }

        return $response->getContent();
    }
}

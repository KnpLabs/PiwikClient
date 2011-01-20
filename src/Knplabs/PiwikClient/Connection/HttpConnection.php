<?php

namespace Knplabs\PiwikClient\Connection;

use Buzz\Browser;

/*
 * This file is part of the PiwikClient.
 * (c) 2011 knpLabs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Piwik HTTP Connector.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class HttpConnection implements ConnectionInterface
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
            $this->browser = new Browser();
        } else {
            $this->browser = $browser;
        }

        $this->apiUrl = $apiUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function callMethod($method, array $params = array())
    {
        $query = array('module=API', 'method=' . $method);
        foreach ($params as $key => $val) {
            if (is_array($val)) {
                $val = implode(',', $val);
            } elseif ($val instanceof \DateTime) {
                $val = $val->format('Y-m-d');
            } else {
                $val = urlencode($val);
            }
            $query[] = $key . '=' . $val;
        }
        $query[] = 'format=json';

        $url = $this->apiUrl . '?' . implode('&', $query);

        return json_decode($this->browser->get($url)->getContent(), true);
    }
}

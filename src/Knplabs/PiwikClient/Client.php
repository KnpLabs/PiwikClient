<?php

/*
 * This file is part of the PiwikClient.
 * (c) 2011 knpLabs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Knplabs\PiwikClient;

use Knplabs\PiwikClient\Connection\ConnectionInterface;

/**
 * Piwik Client.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class Client
{
    private $connection;
    private $token;

    /**
     * Initialize Piwik client.
     *
     * @param   ConnectionInterface $connection     Piwik active connection
     * @param   string              $token          auth token
     */
    public function __construct(ConnectionInterface $connection, $token = '')
    {
        $this->connection = $connection;
        $this->token      = $token;
    }

    /**
     * Call specific method & return it's response.
     *
     * @param   string  $method     method name
     * @param   array   $params     method parameters
     * 
     * @return  array
     */
    public function call($method, array $params = array())
    {
        $params['token_auth'] = $this->token;

        return $this->getConnection()->callMethod($method, $params);
    }

    /**
     * Return active connection.
     *
     * @return  ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }
}

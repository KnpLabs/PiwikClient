<?php

/*
 * This file is part of the PiwikClient.
 * (c) 2013 Knp Labs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Knp\PiwikClient\Connection;

/**
 * Piwik Stub Connector.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class StubConnection implements ConnectionInterface
{
    protected $requests     = array();
    protected $responses    = array();

    /**
     * Return all maded requests. 
     * 
     * @return  array
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * Add response to queue. 
     * 
     * @param   string  $response   stub response
     */
    public function addResponse($response)
    {
        $this->responses[] = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function send(array $params = array())
    {
        $this->requests[] = $params;

        return array_pop($this->responses);
    }
}

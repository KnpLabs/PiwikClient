<?php

namespace Knp\PiwikClient\Connection;

/**
 * Piwik Client Abstract Connection.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
interface ConnectionInterface
{
    /**
     * Calls specific method on Piwik API.
     *
     * @param   array   $params     parameters (associative array)
     * 
     * @return  string              response
     */
    function send(array $params = array());
}

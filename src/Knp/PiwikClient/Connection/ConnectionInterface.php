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

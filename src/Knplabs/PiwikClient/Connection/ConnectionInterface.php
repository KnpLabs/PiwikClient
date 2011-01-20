<?php

namespace Knplabs\PiwikClient\Connection;

/*
 * This file is part of the PiwikClient.
 * (c) 2011 knpLabs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * @param   string  $method     method name (API.getDefaultMetrics, Actions.getPageUrls, etc.)
     * @param   array   $params     method parameters (associative array)
     * 
     * @return  array               method response
     */
    function callMethod($method, array $params = array());
}

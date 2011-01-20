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
 * Piwik Lib Connector.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class PiwikConnection implements ConnectionInterface
{
    /**
     * Initialize Piwik Connector.
     * 
     * require_once PIWIK_INCLUDE_PATH . "/index.php";
     * require_once PIWIK_INCLUDE_PATH . "/core/API/Request.php";
     * Piwik_FrontController::getInstance()->init();
     * 
     * $con = new Knplabs\PiwikClient\Connection\PiwikConnection();
     * 
     * @param   boolean $initFrontController    will init Piwik instance if true
     */
    public function __construct($initFrontController = false)
    {
        if ($initFrontController) {
            \Piwik_FrontController::getInstance()->init();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function callMethod($method, array $params = array())
    {
        $query = array('method=' . $method);
        foreach ($params as $key => $val) {
            if (is_array($val)) {
                $val = implode(',', $val);
            } elseif ($val instanceof \DateTime) {
                $val = $val->format('Y-m-d');
            }
            $query[] = $key . '=' . $val;
        }
        $query[] = 'format=json';

        $request = new \Piwik_API_Request(implode('&', $query));

        return json_decode($request->process(), true);
    }
}

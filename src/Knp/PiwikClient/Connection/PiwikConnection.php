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
     * $con = new Knp\PiwikClient\Connection\PiwikConnection();
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
    public function send(array $params = array())
    {
        $request = new \Piwik_API_Request($this->convertParamsToQuery($params));

        return $request->process();
    }

    /**
     * Convert hash of parameters to query string. 
     * 
     * @param   array   $params hash
     *
     * @return  string          query string
     */
    protected function convertParamsToQuery(array $params)
    {
        $query = array();

        foreach ($params as $key => $val) {
            if (is_array($val)) {
                $val = implode(',', $val);
            } elseif ($val instanceof \DateTime) {
                $val = $val->format('Y-m-d');
            } elseif (is_bool($val)) {
                if ($val) {
                    $val = 1;
                } else {
                    continue;
                }
            } else {
                $val = urlencode($val);
            }
            $query[] = $key . '=' . $val;
        }

        return implode('&', $query);
    }
}

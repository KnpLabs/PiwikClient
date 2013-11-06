<?php

/*
 * This file is part of the PiwikClient.
 * (c) 2013 Knp Labs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Knp\PiwikClient\Exception;

/**
 * Piwik Client Exception.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class Exception extends \Exception
{
    public function __construct($message)
    {
        $message = 'Piwik API error: ' . $message;

        parent::__construct($message);
    }
}

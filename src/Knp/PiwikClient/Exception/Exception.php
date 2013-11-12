<?php

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

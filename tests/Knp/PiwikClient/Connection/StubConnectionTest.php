<?php

/*
 * This file is part of the PiwikClient.
 * (c) 2013 Knp Labs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\Knp\PiwikClient\Connection;

use Knp\PiwikClient\Connection\StubConnection;

class StubConnectionTest extends \PHPUnit_Framework_TestCase
{


    /* TEST SEND
     *************************************************************************/
    public function testSend()
    {
        $con = new StubConnection();
        $con->addResponse($resp = 'some resp');

        $this->assertEquals($resp, $con->send($params = array('method' => 'API.Test', 'format' => 'xml')));

        $requests = $con->getRequests();

        $this->assertEquals($params, $requests[0]);
    }
}

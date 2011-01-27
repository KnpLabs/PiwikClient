<?php

namespace Test\Knplabs\PiwikClient\Connection;

use Knplabs\PiwikClient\Connection\StubConnection;

class StubConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testMethodCalls()
    {
        $con = new StubConnection();
        $con->addResponse($resp = 'some resp');

        $this->assertEquals($resp, $con->send($params = array('method' => 'API.Test', 'format' => 'xml')));

        $requests = $con->getRequests();

        $this->assertEquals($params, $requests[0]);
    }
}

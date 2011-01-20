<?php

namespace Test\Knplabs\PiwikClient\Connection;

use Buzz;
use Knplabs\PiwikClient\Connection\HttpConnection;

class HttpConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testMethodCalls()
    {
        $browser = new Buzz\Browser(new Buzz\Client\Mock\LIFO());
        $con     = new HttpConnection('http://example.com', $browser);

        $browser->getClient()->sendToQueue($this->createResponse(json_encode($resp = array(
            'key1' => 'val1'
        ))));
        $this->assertEquals($resp, $con->callMethod('VisitsSummary.getVisits'));

        $request = $browser->getJournal()->getLastRequest();
        $this->assertEquals(
            'http://example.com/?module=API&method=VisitsSummary.getVisits&format=json',
            $request->getUrl()
        );

        $browser->getClient()->sendToQueue($this->createResponse(json_encode($resp = array(
            'key1' => 'val1',
            'key2' => 'val2'
        ))));
        $this->assertEquals($resp, $con->callMethod('Actions.getOutlinks', array(
            'idSite' => 2,
            'period' => 'week',
            'date'   => new \DateTime('2009/03/12'),
            'arr'    => array(2, 3, 4)
        )));

        $request = $browser->getJournal()->getLastRequest();
        $this->assertEquals(
            'http://example.com/?module=API&method=Actions.getOutlinks' .
            '&idSite=2&period=week&date=2009-03-12&arr=2,3,4&format=json',
            $request->getUrl()
        );
    }

    protected function createResponse($content)
    {
        $resp = new Buzz\Message\Response();
        $resp->fromString("200 OK\n\n" . $content);

        return $resp;
    }
}

<?php

namespace Test\Knplabs\PiwikClient\Connection;

use Buzz;
use Knplabs\PiwikClient\Connection\HttpConnection;

class HttpConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $browser = new Buzz\Browser(new Buzz\Client\Mock\LIFO());
        $con     = new HttpConnection('http://example.com', $browser);

        $browser->getClient()->sendToQueue($this->createResponse($resp = serialize(array(
            'key1' => 'val1'
        ))));
        $this->assertEquals($resp, $con->send(array('method' => 'VisitsSummary.getVisits', 'format' => 'php')));

        $request = $browser->getJournal()->getLastRequest();
        $this->assertEquals(
            'http://example.com/?method=VisitsSummary.getVisits&format=php&module=API',
            $request->getUrl()
        );

        $browser->getClient()->sendToQueue($this->createResponse($resp = serialize(array(
            'key1' => 'val1',
            'key2' => 'val2'
        ))));
        $this->assertEquals($resp, $con->send(array(
            'method' => 'Actions.getOutlinks',
            'idSite' => 2,
            'period' => 'week',
            'bool1'  => true,
            'bool2'  => false,
            'date'   => new \DateTime('2009/03/12'),
            'arr'    => array(2, 3, 4),
            'format' => 'php'
        )));

        $request = $browser->getJournal()->getLastRequest();
        $this->assertEquals(
            'http://example.com/?method=Actions.getOutlinks' .
            '&idSite=2&period=week&bool1=1&date=2009-03-12&arr=2,3,4&format=php&module=API',
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

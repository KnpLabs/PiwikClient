<?php

namespace Test\Knplabs\PiwikClient;

use Knplabs\PiwikClient\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testConnection()
    {
        $client = new Client($con = $this->getConnectionMock());

        $this->assertSame($con, $client->getConnection());
    }

    public function testCall()
    {
        $client = new Client($con = $this->getConnectionMock(), '123');

        $con
            ->expects($this->once())
            ->method('send')
            ->with(array(
                'method'    => 'API.getReportMetadata',
                'token_auth'=> '123',
                'idSites'   => array(2, 3),
                'format'    => 'json'
            ))
            ->will($this->returnValue($ret = 'some ret text'));

        $this->assertEquals($ret, $client->call('API.getReportMetadata', array('idSites' => array(2, 3)), 'json'));
    }

    public function testPhpCall()
    {
        $client = new Client($con = $this->getConnectionMock(), '123');

        $con
            ->expects($this->once())
            ->method('send')
            ->with(array(
                'method'    => 'API.getReportMetadata',
                'token_auth'=> '123',
                'format'    => 'php'
            ))
            ->will($this->returnValue(serialize($ret = array('1st' => 1, '2nd' => 2))));

        $this->assertEquals($ret, $client->call('API.getReportMetadata'));
    }

    protected function getConnectionMock()
    {
        return $this->getMockBuilder('Knplabs\PiwikClient\Connection\HttpConnection')
            ->disableOriginalConstructor()
            ->getMock();
    }
}

<?php

/*
 * This file is part of the PiwikClient.
 * (c) 2013 Knp Labs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\Knp\PiwikClient;

use Knp\PiwikClient\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{


    /* TEST GET CONNECTION
     *************************************************************************/
    public function testConnection()
    {
        $connection = $this->getConnectionMock();
        $client = new Client($connection);
        $this->assertSame($connection, $client->getConnection());
    }


    /* TEST CALL
     *************************************************************************/
    /**
     * @dataProvider providerCall
     */
    public function testCall($assertResponse, $responseText, $format)
    {
        $connection = $this->getConnectionMock();
        $client = new Client($connection, '123');

        $connection
            ->expects($this->once())
            ->method('send')
            ->with(array(
                'method'    => 'API.getReportMetadata',
                'token_auth'=> '123',
                'idSite'   => array(2, 3),
                'format'    => $format
            ))
            ->will($this->returnValue($responseText));

        $actualResponse = $client->call('API.getReportMetadata', array('idSite' => array(2, 3)), $format);
        $this->assertEquals($assertResponse, $actualResponse);
    }

    public function providerCall()
    {
        $assertResponse = array('1st' => 1, '2nd' => 'string');
        return array(
            // Deserialization expected with php format
            array($assertResponse, serialize($assertResponse), 'php'),
            // No treatment expected with other format
            array($assertResponse, $assertResponse, 'json')
        );
    }


    /* TEST CALL EXCEPTION
     *************************************************************************/
    public function testCallException()
    {
        $connection = $this->getConnectionMock();
        $client = new Client($connection, '123');

        $connection
            ->expects($this->once())
            ->method('send')
            ->will($this->returnValue(serialize(array('result'=>'error', 'message'=>'test'))));

        $this->setExpectedException('Knp\PiwikClient\Exception\Exception');
        $client->call('API.getReportMetadata');
    }


    /* UTILS
     *************************************************************************/
    protected function getConnectionMock()
    {
        return $this->getMockBuilder('Knp\PiwikClient\Connection\HttpConnection')
            ->disableOriginalConstructor()
            ->getMock();
    }
}

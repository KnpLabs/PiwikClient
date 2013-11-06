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
        $client = new Client($con = $this->getConnectionMock());

        $this->assertSame($con, $client->getConnection());
    }


    /* TEST CALL FORMAT JSON
     *************************************************************************/
    /**
     * @dataProvider providerCall
     */
    public function testCall($assertResponse, $responseText, $format)
    {
        $client = new Client($con = $this->getConnectionMock(), '123');

        $con
            ->expects($this->once())
            ->method('send')
            ->with(array(
                'method'    => 'API.getReportMetadata',
                'token_auth'=> '123',
                'idSites'   => array(2, 3),
                'format'    => $format
            ))
            ->will($this->returnValue($responseText));

        $actualResponse = $client->call('API.getReportMetadata', array('idSites' => array(2, 3)), $format);
        $this->assertEquals($assertResponse, $actualResponse);
    }

    public function providerCall()
    {
        $assertResponse = array('1st' => 1, '2nd' => 'string');
        return array(
            // Unserializing expected with php format
            array($assertResponse, serialize($assertResponse), 'php'),
            // No treatment expected with other format
            array($assertResponse, $assertResponse, 'json')
        );
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

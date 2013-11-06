<?php

/*
 * This file is part of the PiwikClient.
 * (c) 2013 Knp Labs <http://www.knplabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\Knp\PiwikClient\Connection;

use Buzz;
use Knp\PiwikClient\Connection\HttpConnection;

class HttpConnectionTest extends \PHPUnit_Framework_TestCase
{


    /* ATTRIBUTES
     *************************************************************************/
    private $browser;
    private $httpConnection;
    private $domain = 'http://example.com';


    /* UTILS
     *************************************************************************/
    protected function setUp()
    {
        $this->browser = $this->getMockBuilder('Buzz\\Browser')
            ->disableOriginalConstructor()
            ->getMock();
        $this->httpConnection = new HttpConnection($this->domain, $this->browser);
    }

    protected function createResponse($content='')
    {
        $response = new Buzz\Message\Response();
        $response->addHeader('1.0 200 OK');
        $response->setContent($content);
        return $response;
    }


    /* TEST SEND URL
     *************************************************************************/
    /**
     * @dataProvider providerSendUrl
     */
    public function testSendUrl($params, $url)
    {
        $response = $this->createResponse();

        $this->browser
            ->expects($this->once())
            ->method('get')
            ->with($url)
            ->will($this->returnValue($response));

        $this->httpConnection->send($params);
    }

    public function providerSendUrl()
    {
        return array(
            array(
                array('method' => 'VisitsSummary.getVisits', 'format' => 'php'),
                $this->domain.'?method=VisitsSummary.getVisits&format=php&module=API'
            ),
            array(
                array(
                    'method' => 'Actions.getOutlinks',
                    'idSite' => 2,
                    'period' => 'week',
                    'bool1'  => true,
                    'bool2'  => false,
                    'date'   => new \DateTime('2009/03/12', new \DateTimeZone('Europe/Paris')),
                    'arr'    => array(2, 3, 4),
                    'format' => 'php'
                ),
                $this->domain.'?method=Actions.getOutlinks&idSite=2&period=week&bool1=1&date=2009-03-12&arr=2,3,4&format=php&module=API'
            )
        );
    }


    /* TEST SEND RESPONSE
     *************************************************************************/
    /**
     * @dataProvider providerSendResponse
     */
    public function testSendResponse($responseArray)
    {
        $assertResponse = serialize($responseArray);
        $response = $this->createResponse($assertResponse);

        $this->browser
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue($response));

        $actualResponse = $this->httpConnection->send();
        $this->assertEquals($assertResponse, $actualResponse);
    }

    public function providerSendResponse()
    {
        return array(
            array('key1' => 'val1'),
            array(
                'key1' => 'val1',
                'key2' => 'val2'
            )
        );
    }
}

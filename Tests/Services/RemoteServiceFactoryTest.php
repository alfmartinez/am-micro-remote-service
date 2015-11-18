<?php

namespace Micro\RemoteServiceBundle\Tests\Services;

use Micro\RemoteServiceBundle\Services\RemoteServiceFactory;
use Mockery as m;

class RemoteServiceFactoryTest extends \PHPUnit_Framework_TestCase {

    const className = 'Micro\RemoteServiceBundle\Tests\Util\MockService';
    const name = 'testService';
    const registryUrl = 'http://test.example.com';
    const serviceUrl = 'http://test.service.com/';

    private $service;

    public function setup() {
        $this->setRequestMock();
        $this->service = RemoteServiceFactory::createService(
                        self::name, self::className, self::registryUrl
        );
    }

    /**
     * @test
     */
    public function serviceIsExpectedMockService() {
        $this->assertInstanceOf(self::className, $this->service);
    }
    
    /**
     * @test
     */
    public function serviceHasClientToRemoteService(){
        $client = $this->service->getClient();
        $this->assertInstanceOf('Micro\ClientBundle\Rest\Client', $client);
        $this->assertAttributeEquals(self::serviceUrl, 'url', $client);
    }

    private function setRequestMock() {
        $mock = m::mock('alias:Httpful\Request');
        $mock
                ->shouldReceive('get')
                ->with(self::registryUrl . '/api/services/testService/provider')
                ->andReturnSelf();
        $mock
                ->shouldReceive('expectsJson')
                ->andReturnSelf();
        $mock
                ->shouldReceive('withXTrivialHeader')
                ->with('Asking registry')
                ->andReturnSelf();
        $mock
                ->shouldReceive('send')
                ->andReturn((object)[ 'body' => (object)[
                    'url' => self::serviceUrl
                ]]);
             
    }

}

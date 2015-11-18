<?php

namespace Micro\RemoteServiceBundle\Tests\Util;

class MockService {

    private $client;

    function __construct($client) {
        $this->client = $client;
    }
    
    function getClient() {
        return $this->client;
    }



}

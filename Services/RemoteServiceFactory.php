<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Micro\RemoteServiceBundle\Services;

use Micro\ClientBundle\Rest\Client;
use Httpful\Request;

/**
 * Description of RemoteServiceFactory
 *
 * @author alex
 */
class RemoteServiceFactory {

    public static function createService($name, $className, $registryUrl) {
        $url = self::getServiceUrl($name, $registryUrl);
        $client = new Client($url);
        $service = new $className($client);
        return $service;
    }

    private static function getServiceUrl($name, $registryUrl) {
        $uri = $registryUrl . "/api/services/$name/provider";
        $response = Request::get($uri)
                ->expectsJson()
                ->withXTrivialHeader('Asking registry')
                ->send();

        return $response->body->url;
    }

}

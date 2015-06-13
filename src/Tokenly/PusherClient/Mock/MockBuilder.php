<?php

namespace Tokenly\PusherClient\Mock;

use Exception;
use Illuminate\Foundation\Application;
use \PHPUnit_Framework_MockObject_MockBuilder;
use \PHPUnit_Framework_TestCase;

/**
* Pusher Mock Builder
* for Laravel apps
*/
class MockBuilder
{

    function __construct(Application $app) {
        $this->app = $app;
    }
    

    ////////////////////////////////////////////////////////////////////////

    public function installPusherMockClient(PHPUnit_Framework_TestCase $test_case=null) {
        // record the calls
        $pusher_recorder = new \stdClass();
        $pusher_recorder->calls = [];

        if ($test_case === null) { $test_case = new \Tokenly\PusherClient\Mock\MockTestCase(); }

        $pusher_client_mock = $test_case->getMockBuilder('\Tokenly\PusherClient\Client')
            ->disableOriginalConstructor()
            ->getMock();

        // install the pusher client into the DI container
        $this->app->bind('Tokenly\PusherClient\Client', function($app) use ($pusher_client_mock) {
            return $pusher_client_mock;
        });


        // return an object to check the calls
        return $pusher_recorder;
    }

    ////////////////////////////////////////////////////////////////////////

}
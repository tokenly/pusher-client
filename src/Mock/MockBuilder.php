<?php

namespace Tokenly\PusherClient\Mock;

use Exception;
use Mockery as m;
use Tokenly\PusherClient\Mock\Notifications;

/**
* Pusher Mock Builder
* for Laravel apps
*/
class MockBuilder
{

    static $INSTANCE;

    protected $notifications = null;
    protected $mock_client   = null;
    
    public function __construct() {
        $this->notifications = new Notifications();
    }

    ////////////////////////////////////////////////////////////////////////

    public function installPusherMockClient() {
        if (!self::$INSTANCE) {
            self::$INSTANCE = $this;
        }

        return self::$INSTANCE->setupMock();
    }


    public function setupMock() {
        if (is_null($this->mock_client)) {
            $this->mock_client = m::mock('Tokenly\PusherClient\Client', function ($mock_builder) {
                $mock_builder->shouldReceive('send')->andReturnUsing(function($channel, $data=[], $ext=[]) {
                    $this->notifications->recordNotification($channel, $data);
                    return;
                });
            })->makePartial();
        } else {
            // not the first time
            //   reset the called api methods
            $this->notifications->reset();
        }

        // overwrite Laravel binding
        app()->bind('Tokenly\PusherClient\Client', function($app) {
            return $this->mock_client;
        });


        // return an object to check the calls
        return $this->notifications;
    }

    ////////////////////////////////////////////////////////////////////////

}
<?php

namespace Tokenly\PusherClient\Mock;

use ArrayObject;

class Notifications extends ArrayObject {

    function __construct() {
        $data = [];
        $data['notifications'] = [];

        return parent::__construct($data);
    }


    public function recordNotification($channel, $data) {
        $this['notifications'][] = [
            'channel' => $channel,
            'data'    => $data,
        ];
    }

    public function getAllNotifications() {
        return $this['notifications'];
    }

    public function getNotification($offset, $array_key=null) {
        $out = isset($this['notifications'][$offset]) ? $this['notifications'][$offset] : null;
        if ($out === null) { return null; }

        if ($array_key !== null) {
            return isset($out[$array_key]) ? $out[$array_key] : null;
        }

        return $out;
    }

    public function reset() {
        $this['notifications'] = [];
    }

}

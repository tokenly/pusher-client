A client component for the client-side messaging pusher service.

### Installation

- `composer require tokenly/pusher-client`
- Add `Tokenly\PusherClient\Provider\Client::class` to the list of service providers

### Environment Variables

Set the following environment variables

- `PUSHER_SERVER_URL` (optional, defaults to https://pusher.tokenly.com)
- `PUSHER_CLIENT_URL` (optional, defaults to the server URL)
- `PUSHER_PASSWORD`   (required for Tokenly services)

### Server-side Usage

#### Send an event

```php
$channel = 'my-event-channel-name';
$data = json_encode(['fromUser' => 'fred', 'messageId' => 101, 'messageText' => 'hello world!']);

$pusher = app(\Tokenly\PusherClient\Client::class);
$pusher->send($channel, $data);
```

### Client-side Usage

See the [pusher-client.js example](examples/js/pusher-client.js) for the client javascript code.

#### Step 1: Include the two libraries

This is best toward the end of your body tag.

```html
<script src="https://pusher.tokenly.com/public/client.js"></script>
<script src="/path/to/js/pusher-client.js"></script>
```

#### Step 2: Subscribe and respond to events

After the two script tags below are loaded, you can subscribe to a channel

```html
<script>
    var subscribedClient = PusherClient.subscribeToPusherChanel('my-event-channel-name', function(dataReceived) {
        // received a websocket message on channel /my-event-channel-name
        console.log('user '+dataReceived.fromUser+' said '+messageText);
    });
</script>
```

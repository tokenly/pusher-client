window.PusherClient = function(window) {

  var MISSING_PUSHER_ERROR_SEEN = false;
  var exports = {};

  exports.subscribeToPusherChanel = function(channelName, callbackFn, pusherUrl) {
    var client;
    if (pusherUrl == null) {
      pusherUrl = 'https://pusher.tokenly.com';
    }

    if (window.Faye == null) {
      console.error('Pusher client not defined');
      if (!MISSING_PUSHER_ERROR_SEEN) {
        alert('Unable to load the live data feed.  Please reload this page.');
        MISSING_PUSHER_ERROR_SEEN = true;
        window.Bugsnag && Bugsnag.notify("Missing Pusher Reference", "window.Faye was not a valid object");
      }
      return null;
    }

    client = new window.Faye.Client(pusherUrl + "/public");
    client.subscribe("/" + channelName, function(data) {
      callbackFn(data);
    });

    return client;
  };

  exports.closePusherChanel = function(client) {
    if (client != null) {
      client.disconnect();
    }
  };

  return exports;

}(this);


// NodeJS - Client
// inspired and adapted from https://medium.com/@martin.sikora/node-js-websocket-simple-chat-tutorial-2def3a841b61

// retrieve authenticated user's ID
userID = typeof userID !== 'undefined' ? userID : -1;
var connection = null;

// handle websockets only if user is authenticated
if (userID != -1) {
  console.log("NodeJS Client running, id : " + userID);

  window.WebSocket = window.WebSocket || window.MozWebSocket;

  connection = new WebSocket('ws://127.0.0.1:1337');

  connection.onopen = function () {
    // connection is opened and ready to use
    console.log("Connection opened");
    let msg = {type: "greetings", data: userID};
    connection.send(JSON.stringify(msg));
  };

  connection.onerror = function (error) {
    // an error occurred when sending/receiving data
    console.log(error);
  };

  connection.onmessage = function (message) {
    // try to decode json (I assume that each message from server is json)
    try {
      var json = JSON.parse(message.data);

      // handle incoming message
      console.log(message.data);

    } catch (e) {
      console.log('This doesn\'t look like a valid JSON: ', message.data);
      return;
    }
  };
}

// NodeJS - Server
// inspired and adapted from https://medium.com/@martin.sikora/node-js-websocket-simple-chat-tutorial-2def3a841b61
console.log("NodeJS Server running");

var webSocketsServerPort = 1337;
var WebSocketServer = require("websocket").server;
var http = require("http");
var clients = [];
var server = http.createServer(function(request, response) {});

/**
* Helper function for escaping input strings
*/
function htmlEntities(str) {
  return String(str)
  .replace(/&/g, '&amp;').replace(/</g, '&lt;')
  .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

server.listen(webSocketsServerPort, function() {
  console.log((new Date()) + " Server is listening on port " + webSocketsServerPort);
});

// create the server
wsServer = new WebSocketServer({
  httpServer: server
});

// WebSocket server
wsServer.on("request", function(request) {
  console.log((new Date()) + " Connection from origin " + request.origin + ".");
  var connection = request.accept(null, request.origin);
  var index = clients.push({connection: connection, id: -1, username: ""}) - 1;
  console.log((new Date()) + " Connection accepted.");


  connection.on("message", function(message) {
    if (message.type === "utf8") {
      // handle
      console.log("Incoming message : " + message.utf8Data);
      let msgObject = JSON.parse(message.utf8Data);

      switch(msgObject.type) {
        case "greetings":
          clients[index].id = msgObject.userID;
          clients[index].username = msgObject.username;
          break;
        case "shareRequest":
          let clientToIndex = -1;
          for (let i=0; i<clients.length; i++) {
            if (clients[i].username == msgObject.userTo) {
              clientToIndex = i;
              break;
            }
          }

          if (clientToIndex != -1)
            clients[clientToIndex].connection.sendUTF(JSON.stringify(msgObject)); // pass the request further
          else {
            let msg = {type: "shareError", username: msgObject.userTo, errorCode: 0}; // client not connected
            connection.sendUTF(JSON.stringify(msg));
          }
          break;
        default:
      }
    }
  });

  connection.on("close", function(connection) {
    // close user connection
    console.log("Connection closed with a client : " + connection)
    clients.splice(index, 1);
  });
});

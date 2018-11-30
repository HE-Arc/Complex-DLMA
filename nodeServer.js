// NodeJS - Server
// inspired and adapted from https://medium.com/@martin.sikora/node-js-websocket-simple-chat-tutorial-2def3a841b61
console.log("NodeJS Server running");

var webSocketsServerPort = 1337;
var WebSocketServer = require("websocket").server;
var http = require("http");
var server = http.createServer(function(request, response) {});
var clients = [];


/**
 * htmlEntities
 * Helper function for escaping input strings
 * 
 * @param {String} str - string to escape
 */
function htmlEntities(str) {
  return String(str)
  .replace(/&/g, '&amp;').replace(/</g, '&lt;')
  .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

/**
 * findClientByUsername
 * Searches the given username in the clients list and returns client's id or -1 if
 * there is no register client with username.
 * 
 * @param {String} searchedClientUsername - searched username in clients list
 */
function findClientByUsername(searchedClientUsername) {
  for (let i=0; i<clients.length; i++) {
    if (clients[i].username == searchedClientUsername)
      return i;
  }
  return -1;
}

// listen on web socket's port for new clients
server.listen(webSocketsServerPort, function() {
  console.log((new Date()) + " Server is listening on 127.0.0.1:" + webSocketsServerPort);
});

// creates the server
wsServer = new WebSocketServer({
  httpServer: server
});

// WebSocket server
wsServer.on("request", function(request) {
  console.log((new Date()) + " Connection from origin " + request.origin + ".");

  // accept client's connection
  var connection = request.accept(null, request.origin);

  // push the new client to the clients list
  var index = clients.push({connection: connection, id: -1, username: ""}) - 1;
  console.log((new Date()) + " Connection accepted.");

  // handles incoming messages
  connection.on("message", function(message) {
    if (message.type === "utf8") {
      // handle message
      // console.log("Incoming message : " + message.utf8Data);
      let msgObject = JSON.parse(message.utf8Data);

      switch(msgObject.type) {
        case "greetings": // handles user's greetings (first message exchanged)
          clients[index].id = msgObject.userID;
          clients[index].username = msgObject.username;
          break;
        case "shareRequest": // handles incoming share request
          var clientToIndex = findClientByUsername(msgObject.userTo);
          var clientFromIndex = findClientByUsername(msgObject.userFrom);

          if (clientToIndex != -1 && clientFromIndex != -1)
            clients[clientToIndex].connection.sendUTF(JSON.stringify(msgObject)); // pass the request further
          else {
            if (clientToIndex == -1) {
              let msg = {type: "shareError", username: msgObject.userTo, errorCode: 0}; // client not connected
              connection.sendUTF(JSON.stringify(msg));
            }
          }
          break;
        case "shareRequestAnswer": // handles incoming share request's
          var clientToIndex = findClientByUsername(msgObject.userTo);
          var clientFromIndex = findClientByUsername(msgObject.userFrom);

          if (clientToIndex != -1 && clientFromIndex != -1)
            clients[clientToIndex].connection.sendUTF(JSON.stringify(msgObject)); // pass the request further
          break;
        default:
      }
    }
  });

  // handles client's connection close
  connection.on("close", function(connection) {
    // close user connection
    console.log("Connection closed with a client : " + connection)
    clients.splice(index, 1);
  });
});

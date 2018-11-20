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

  connection.onopen = function() {
    // connection is opened and ready to use
    console.log("Connection opened");
    let msg = {type: "greetings", userID: userID, username: username};
    connection.send(JSON.stringify(msg));
  };

  connection.onerror = function(error) {
    // an error occurred when sending/receiving data
    console.log(error);
  };

  connection.onmessage = function(message) {
    try {
      let msgObject = JSON.parse(message.data);

      // handle incoming message
      console.log(message.data);

      switch(msgObject.type) {
        case "shareRequest":
          console.log("partage d'une question par " + msgObject.userTo);

          $("#shareMyChoicePopup").fadeIn(750);
          $("#btnCloseShareMyChoice").click(function(){
            $("#shareMyChoicePopup").hide(200);
          });

          initShareMyChoicePopup(msgObject);
          break;
        case "shareError":
          switch(msgObject.errorCode) {
            case 0:
              alert("'" + msgObject.userTo + "' isn't currently online.");
              break;
          }
          break;
      }
    } catch (e) {
      console.log(e);
      return;
    }
  };
}

function sendShareRequest(usernameTo) {
  let msg = {type: "shareRequest", userFrom: username, userTo: usernameTo, questionTitle: questionTitle, questionChoice1: questionChoice1, questionChoice2: questionChoice2};
  connection.send(JSON.stringify(msg));
}

function initShareMyChoicePopup(msg) {
  document.getElementById("shareMyChoicePopupTitle").innerHTML = "'" + msg.userTo + "' wants to know your opinion !";
  let node = document.getElementById("shareMyChoicePopupQuestion");

  let nodeTitle = document.createElement("div");
  nodeTitle.appendChild(document.createTextNode(msg.questionTitle));

  let btnChoice1 = document.createElement("button");
  btnChoice1.appendChild(document.createTextNode(msg.questionChoice1));
  btnChoice1.onclick = () => console.log("1");

  let btnChoice2 = document.createElement("button");
  btnChoice2.appendChild(document.createTextNode(msg.questionChoice2));
  btnChoice2.onclick = () => console.log("2");

  node.appendChild(nodeTitle);
  node.appendChild(btnChoice1);
  node.appendChild(btnChoice2);
}

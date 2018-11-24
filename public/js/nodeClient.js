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
          console.log("'" + msgObject.userTo + "' shared a question with you !");

          initShareMyChoicePopup(msgObject);

          $("#shareMyChoicePopup").fadeIn(750);
          $("#btnCloseShareMyChoice").click(closeShareMyChoicePopup);

          break;
        case "shareRequestAnswer":
          console.log("'" + msgObject.userFrom + "' has responded to your shared choice : choice n°" + msgObject.choiceMade);

          initChoiceSharingAnswerPopup(msgObject);

          $("#choiceSharingAnswerPopup").fadeIn(750);
          $("#btnCloseChoiceSharingAnswerPopup").click(function(){
            $("#choiceSharingAnswerPopup").hide(200);
            document.getElementById("choiceSharingAnswerPopupRes").innerHTML = "";
          });
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

function initShareMyChoicePopup(msg) {
  document.getElementById("shareMyChoicePopupTitle").innerHTML = "Share requests";
  let node = document.getElementById("shareMyChoicePopupQuestion");
  let nodeRequest = document.createElement("div");
  nodeRequest.id = "shareMyChoicePopupRequest" + document.querySelectorAll("#shareMyChoicePopupQuestion .shareMyChoicePopupRequest").length;
  nodeRequest.classList.add("shareMyChoicePopupRequest");

  let nodeElementTitle = document.createElement("div");
  nodeElementTitle.appendChild(document.createTextNode("'" + msg.userTo + "' wants to know your opinion !"));

  let nodeQuestionTitle = document.createElement("div");
  nodeQuestionTitle.appendChild(document.createTextNode(msg.questionTitle));

  let btnChoice1 = document.createElement("button");
  btnChoice1.appendChild(document.createTextNode(msg.questionChoice1));
  btnChoice1.onclick = () => sendAnswerShareRequest(1, msg, nodeRequest.id);

  let btnChoice2 = document.createElement("button");
  btnChoice2.appendChild(document.createTextNode(msg.questionChoice2));
  btnChoice2.onclick = () => sendAnswerShareRequest(2, msg, nodeRequest.id);

  btnChoice1.style = "display: inline-block;";
  btnChoice2.style = "display: inline-block;";

  if(node.innerHTML != "")
    nodeRequest.appendChild(document.createElement("hr"));

  nodeRequest.appendChild(nodeElementTitle);
  nodeRequest.appendChild(nodeQuestionTitle);
  nodeRequest.appendChild(btnChoice1);
  nodeRequest.appendChild(btnChoice2);
  node.appendChild(nodeRequest);
}

function initChoiceSharingAnswerPopup(msg) {
  document.getElementById("choiceSharingAnswerPopupTitle").innerHTML = "Shared opinions";
  let node = document.getElementById("choiceSharingAnswerPopupRes");
  let nodeAnswer = document.createElement("div");

  let titleResult = "'" + msg.userTo + "' shared his/her opinion with you !";
  let chosenChoice = msg.choiceMade == 1 ? msg.choice1 : msg.choice2;
  let otherChoice = msg.choiceMade == 1 ? msg.choice2 : msg.choice1;
  let response = "'" + msg.userTo + "' would rather " + chosenChoice + " than " + otherChoice;

  if(node.innerHTML != "")
    nodeAnswer.appendChild(document.createElement("hr"));

  let titleNode = document.createElement("div");
  titleNode.appendChild(document.createTextNode(titleResult));
  let contentNode = document.createElement("div");
  contentNode.appendChild(document.createTextNode(response));

  nodeAnswer.appendChild(titleNode);
  nodeAnswer.appendChild(contentNode);
  node.appendChild(nodeAnswer);
}

function closeShareMyChoicePopup() {
  $("#shareMyChoicePopup").hide(200);
  document.getElementById("shareMyChoicePopupQuestion").innerHTML = "";
}

function sendShareRequest(usernameTo) {
  let msg = {type: "shareRequest", userFrom: username, userTo: usernameTo,
             questionTitle: questionTitle, questionChoice1: questionChoice1, questionChoice2: questionChoice2};
  connection.send(JSON.stringify(msg));
}

function sendAnswerShareRequest(choiceMade, shareRequestMsg, nodeId) {
  document.getElementById(nodeId).remove();
  if (document.querySelectorAll("#shareMyChoicePopupQuestion .shareMyChoicePopupRequest").length == 0)
    closeShareMyChoicePopup();

  let msg = {type: "shareRequestAnswer", userFrom: shareRequestMsg.userTo, userTo: shareRequestMsg.userFrom,
             choiceMade: choiceMade, choice1: shareRequestMsg.questionChoice1, choice2: shareRequestMsg.questionChoice2};
  connection.send(JSON.stringify(msg));
}

// auto focus modal input
$(".modal").on("shown.bs.modal", function() {
  $(this).find("[autofocus]").focus();
});

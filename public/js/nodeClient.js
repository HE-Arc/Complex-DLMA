// NodeJS - Client
// inspired and adapted from https://medium.com/@martin.sikora/node-js-websocket-simple-chat-tutorial-2def3a841b61

// retrieve authenticated user's ID
userID = typeof userID !== "undefined" ? userID : -1;

var connection = null;
var serverAddress = "ws://127.0.0.1:1337";

// use websockets only if user is authenticated
if (userID != -1) {
  console.log("NodeJS Client running, id : " + userID);

  // browsers compatibility 
  window.WebSocket = window.WebSocket || window.MozWebSocket;

  // creates a new web socket
  connection = new WebSocket(serverAddress);

  // handles newly opened connection
  connection.onopen = function() {
    // connection is opened and ready to use
    console.log("Connection opened");

    // send greetings (basic user's infos needed server side)
    let msg = {type: "greetings", userID: userID, username: username};
    connection.send(JSON.stringify(msg));
  };

  // handles connection errors
  connection.onerror = function(error) {
    // an error occurred when sending/receiving data
    console.log(error);
  };

  // handles incoming message
  connection.onmessage = function(message) {
    try {
      let msgObject = JSON.parse(message.data);

      console.log(message.data);

      switch(msgObject.type) {
        case "shareRequest": // handle incoming share request
          console.log("'" + msgObject.userTo + "' shared a question with you !");
          initShareMyChoicePopup(msgObject);
          break;
        case "shareRequestAnswer": // handle incoming share request's answer
          console.log("'" + msgObject.userFrom + "' has responded to your shared choice : choice n°" + msgObject.choiceMade);
          initChoiceSharingAnswerPopup(msgObject);
          break;
        case "shareError": // handle incoming error message
          switch(msgObject.errorCode) {
            case 0:
              alert("'" + msgObject.username + "' isn't currently online.");
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

// ---

/**
 * initShareMyChoicePopup
 * Creates the DOM content for the given share request.
 * Displays the shared question's in the "shareMyChoicePopup" popup.
 * Fades in the "shareMyChoicePopup" popup when content has been added.
 * 
 * @param {Object} msg - message object containing the share request
 */
function initShareMyChoicePopup(msg) {
  // using HTML structure in layout 'app.blade.php'
  document.getElementById("shareMyChoicePopupTitle").innerHTML = "Share requests"; // window title
  let node = document.getElementById("shareMyChoicePopupQuestion");

  // div containing the new request
  let nodeRequest = document.createElement("div");
  nodeRequest.id = "shareMyChoicePopupRequest" + document.querySelectorAll("#shareMyChoicePopupQuestion .shareMyChoicePopupRequest").length;
  nodeRequest.classList.add("shareMyChoicePopupRequest");

  // request's title
  let nodeElementTitle = document.createElement("div");
  nodeElementTitle.appendChild(document.createTextNode("'" + msg.userTo + "' wants to know your opinion !"));

  // choice 1
  let btnChoice1 = document.createElement("button");
  btnChoice1.appendChild(document.createTextNode(msg.questionChoice1));
  btnChoice1.onclick = () => sendAnswerShareRequest(1, msg, nodeRequest.id);

  // choice 2
  let btnChoice2 = document.createElement("button");
  btnChoice2.appendChild(document.createTextNode(msg.questionChoice2));
  btnChoice2.onclick = () => sendAnswerShareRequest(2, msg, nodeRequest.id);

  // choice 1&2 temporary style
  btnChoice1.style = "display: inline-block;";
  btnChoice2.style = "display: inline-block;";

  // question's description
  let nodeQuestionDescription = document.createElement("div");
  nodeQuestionDescription.appendChild(document.createTextNode(msg.questionDescription));

  // requests separation line
  if(node.innerHTML != "")
    nodeRequest.appendChild(document.createElement("hr"));

  nodeRequest.appendChild(nodeElementTitle);
  nodeRequest.appendChild(btnChoice1);
  nodeRequest.appendChild(btnChoice2);
  nodeRequest.appendChild(nodeQuestionDescription);
  node.appendChild(nodeRequest);

  // display the "shareMyChoicePopup" popup
  $("#shareMyChoicePopup").fadeIn(750);
  $("#btnCloseShareMyChoice").click(closeShareMyChoicePopup);
}

/**
 * initChoiceSharingAnswerPopup
 * Creates the DOM content for the given share request's answer.
 * Displays the answer's content in the "choiceSharingAnswerPopup" popup.
 * Fades in the "choiceSharingAnswerPopup" popup when content has been added.
 * 
 * @param {Object} msg - share request's answer
 */
function initChoiceSharingAnswerPopup(msg) {
  // using HTML structure in view 'index.blade.php'
  document.getElementById("choiceSharingAnswerPopupTitle").innerHTML = "Shared opinions"; // window title
  let node = document.getElementById("choiceSharingAnswerPopupRes");

  // div containing the new answer
  let nodeAnswer = document.createElement("div");

  // answer's texts
  let titleResult = "'" + msg.userTo + "' shared his/her opinion with you !";
  let chosenChoice = msg.choiceMade == 1 ? msg.choice1 : msg.choice2;
  let otherChoice = msg.choiceMade == 1 ? msg.choice2 : msg.choice1;
  let response = "'" + msg.userTo + "' would rather " + chosenChoice + " than " + otherChoice;

  // answers separation line
  if(node.innerHTML != "")
    nodeAnswer.appendChild(document.createElement("hr"));

  // answer's title
  let titleNode = document.createElement("div");
  titleNode.appendChild(document.createTextNode(titleResult));

  // answer's result
  let contentNode = document.createElement("div");
  contentNode.appendChild(document.createTextNode(response));

  nodeAnswer.appendChild(titleNode);
  nodeAnswer.appendChild(contentNode);
  node.appendChild(nodeAnswer);

  // display the "choiceSharingAnswerPopup" popup
  $("#choiceSharingAnswerPopup").fadeIn(750);
  $("#btnCloseChoiceSharingAnswerPopup").click(function(){
    $("#choiceSharingAnswerPopup").hide(200);
    document.getElementById("choiceSharingAnswerPopupRes").innerHTML = "";
  });
}

/**
 * closeShareMyChoicePopup
 * Closes and resets "shareMyChoicePopup" popup.
 */
function closeShareMyChoicePopup() {
  $("#shareMyChoicePopup").hide(200);
  document.getElementById("shareMyChoicePopupQuestion").innerHTML = "";
}

/**
 * sendShareRequest
 * Sends a share request for the current question to a user (identified by the given username).
 * 
 * @param {String} usernameTo - share request's receiver
 */
function sendShareRequest(usernameTo) {
  let msg = {type: "shareRequest", userFrom: username, userTo: usernameTo,
             questionDescription: questionDescription, questionChoice1: questionChoice1, questionChoice2: questionChoice2};
  connection.send(JSON.stringify(msg));
}

/**
 * sendAnswerShareRequest
 * Removes the share request and closes the "shareMyChoicePopup" popup if there's no more.
 * Sends the share request's answer.
 * 
 * @param {int} choiceMade - 1 or 2 for choice1 or choice 2
 * @param {Object} shareRequestMsg  - share request's message object
 * @param {String} nodeId - share request's container id (used to identify which request is answered)
 */
function sendAnswerShareRequest(choiceMade, shareRequestMsg, nodeId) {
  // remove the share request's container from the "shareMyChoicePopup" popup
  document.getElementById(nodeId).remove();

  // if there is no more share request in the popup close the "shareMyChoicePopup" popup
  if (document.querySelectorAll("#shareMyChoicePopupQuestion .shareMyChoicePopupRequest").length == 0)
    closeShareMyChoicePopup();

  // send the share request's answer
  let msg = {type: "shareRequestAnswer", userFrom: shareRequestMsg.userTo, userTo: shareRequestMsg.userFrom,
             choiceMade: choiceMade, choice1: shareRequestMsg.questionChoice1, choice2: shareRequestMsg.questionChoice2};
  connection.send(JSON.stringify(msg));
}

// allows auto focus modal input
$(".modal").on("shown.bs.modal", function() {
  $(this).find("[autofocus]").focus();
});

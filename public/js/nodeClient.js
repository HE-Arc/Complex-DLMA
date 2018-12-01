// NodeJS - Client
// inspired and adapted from https://medium.com/@martin.sikora/node-js-websocket-simple-chat-tutorial-2def3a841b61

// retrieve authenticated user's ID
userID = typeof userID !== "undefined" ? userID : -1;

var connection = null;
var serverAddress = "ws://127.0.0.1:1337";

// use websockets only if user is authenticated
if (userID != -1) {
  // console.log("NodeJS Client running, id : " + userID);

  // browsers compatibility 
  window.WebSocket = window.WebSocket || window.MozWebSocket;

  // creates a new web socket
  connection = new WebSocket(serverAddress);

  // handles newly opened connection
  connection.onopen = function() {
    // connection is opened and ready to use
    // console.log("Connection opened");

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

      // console.log(message.data);

      switch(msgObject.type) {
        case "shareRequest": // handle incoming share request
          // console.log("'" + msgObject.userTo + "' shared a question with you !");
          initShareMyChoicePopup(msgObject);
          break;
        case "shareRequestAnswer": // handle incoming share request's answer
          // console.log("'" + msgObject.userFrom + "' has responded to your shared choice : choice n°" + msgObject.choiceMade);
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
 * Create the entire question DOM.
 * @param {string} choice1
 * @param {string} choice2
 * @param {string} description 
 */
function createDOMQuestion(choice1, choice2, description)
{
  let questionContainer = document.createElement("div");

  // choices
  let choicesContainer = document.createElement("div");
  choicesContainer.className += " row cd_choices-main-container-ask text-center";
  questionContainer.appendChild(choicesContainer);

  // choice 1
  let innerChoice1 = document.createElement("div");
  innerChoice1.className += " col-12 col-lg-6 p-1 p-lg-3 cd_choice-inner-choice1-ask";
  choicesContainer.appendChild(innerChoice1);

  let innerContainerChoice1 = document.createElement("div");
  innerContainerChoice1.className += " btn cd_btn-choice1 userChoice cd_choice-inner-container-ask col-12 h-100 shadow";
  innerChoice1.appendChild(innerContainerChoice1);

  let textContainerChoice1 = document.createElement("div");
  textContainerChoice1.className += " col-12 cd_choice-text-container p-1";
  innerContainerChoice1.appendChild(textContainerChoice1);

  let textChoice1 = document.createElement("div");
  textChoice1.className += " cd_choice-text cd_medium-text font-weight-bold col-12";
  textChoice1.appendChild(document.createTextNode(choice1));
  textContainerChoice1.appendChild(textChoice1);

  // choice 2
  let innerChoice2 = document.createElement("div");
  innerChoice2.className += " col-12 col-lg-6 p-1 p-lg-3 cd_choice-inner-choice2-ask";
  choicesContainer.appendChild(innerChoice2);

  let innerContainerChoice2 = document.createElement("div");
  innerContainerChoice2.className += " btn cd_btn-choice2 userChoice cd_choice-inner-container-ask col-12 h-100 shadow";
  innerChoice2.appendChild(innerContainerChoice2);

  let textContainerChoice2 = document.createElement("div");
  textContainerChoice2.className += " col-12 cd_choice-text-container p-1";
  innerContainerChoice2.appendChild(textContainerChoice2);

  let textChoice2 = document.createElement("div");
  textChoice2.className += " cd_choice-text cd_medium-text font-weight-bold col-12";
  textChoice2.appendChild(document.createTextNode(choice2));
  textContainerChoice2.appendChild(textChoice2);

  // or
  let orChoice = document.createElement("div");
  orChoice.className += " cd_choice-or-ask cd_medium-text rounded-circle col-3 col-lg-1 shadow";
  orChoice.appendChild(document.createTextNode("OR"));
  choicesContainer.appendChild(orChoice);

  // question's description
  let nodeQuestionDescription = document.createElement("div");
  let descriptionText = document.createElement('span');
  descriptionText.appendChild(document.createTextNode("Description : "));
  descriptionText.className += " font-weight-bold";
  nodeQuestionDescription.appendChild(descriptionText);
  nodeQuestionDescription.appendChild(document.createTextNode(description));
  nodeQuestionDescription.className += " cd_small-text";
  questionContainer.appendChild(nodeQuestionDescription);

  return questionContainer;
}

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
  nodeRequest.id = "shareMyChoicePopupRequest_" + Date.now();
  nodeRequest.classList.add("shareMyChoicePopupRequest");

  // request's title
  let nodeElementTitle = document.createElement("div");
  let username = document.createElement("span");
  username.className += " font-weight-bold";
  username.appendChild(document.createTextNode(msg.userFrom));
  nodeElementTitle.appendChild(username);
  nodeElementTitle.appendChild(document.createTextNode(" would like to know your opinion on the follow DLMA !"));
  nodeElementTitle.className += " cd_small-text";

  let questionContainer = createDOMQuestion(msg.questionChoice1, msg.questionChoice2, msg.questionDescription);

  let choice1 = questionContainer.getElementsByClassName("cd_choice-text")[0];
  choice1.onclick = () => sendAnswerShareRequest(1, msg, nodeRequest.id);
  let choice2 = questionContainer.getElementsByClassName("cd_choice-text")[1];
  choice2.onclick = () => sendAnswerShareRequest(2, msg, nodeRequest.id);

  // requests separation line
  if(node.innerHTML != "")
    nodeRequest.appendChild(document.createElement("hr"));

  nodeRequest.appendChild(nodeElementTitle);
  nodeRequest.appendChild(questionContainer);
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
  nodeAnswer.id = "shareRequestAnswer_" + Date.now();
  nodeAnswer.className += " cd_answer-node shareRequestAnswers my-1";

  // question
  let questionContainer = createDOMQuestion(msg.choice1, msg.choice2, msg.description);

  // close button
  let closeButton = document.createElement("div");
  closeButton.className += " btn btn-sm cd_btn-choice-close py-0";
  closeButton.appendChild(document.createTextNode("x"));
  closeButton.id = "shareRequestAnswerButtonClose_" + Date.now();
  closeButton.onclick = () => closeAnswer(nodeAnswer.id);

  // Check the answered choice disable the other
  let disabledChoice;
  let selectedChoice;
  let checkedChoice;
  if(msg.choiceMade == 1) {
    disabledChoice = questionContainer.getElementsByClassName("cd_btn-choice2")[0];
    selectedChoice = questionContainer.getElementsByClassName("cd_btn-choice1")[0];
    checkedChoice = document.createElement("i");
    checkedChoice.id = "checkedChoice1";
  }
  else {
    disabledChoice = questionContainer.getElementsByClassName("cd_btn-choice1")[0];
    selectedChoice = questionContainer.getElementsByClassName("cd_btn-choice2")[0];
    checkedChoice = document.createElement("i");
    checkedChoice.id = "checkedChoice2";
  }
  selectedChoice.appendChild(checkedChoice);
  checkedChoice.className += " fas fa-check cd_checked-choice";
  disabledChoice.className += " cd_btn-choice-disabled";

  // answers separation line
  if(node.innerHTML != "") {
    let hrNode = document.createElement("hr");
    hrNode.className += " cd_hr-s1 my-1";
    nodeAnswer.appendChild(hrNode);
  }

  // answer's title
  let titleResultUser = document.createElement("span");
  titleResultUser.appendChild(document.createTextNode(msg.userFrom))
  titleResultUser.className += " font-weight-bold";
  let titleNode = document.createElement("div");
  titleNode.appendChild(titleResultUser);
  titleNode.appendChild(document.createTextNode(" answered !"));

  nodeAnswer.appendChild(titleNode);
  nodeAnswer.appendChild(questionContainer);
  nodeAnswer.appendChild(closeButton);
  node.appendChild(nodeAnswer);

  // display the "choiceSharingAnswerPopup" popup
  $("#choiceSharingAnswerPopup").fadeIn(750);
  $("#btnCloseChoiceSharingAnswerPopup").click(closeChoiceSharingAnswerPopup);
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
 * closeAnswer
 * Removes the answer and closes the "choiceSharingAnswerPopup" popup if there's no more.
 * 
 * @param {String} nodeId - answer's container id (used to identify which answer has to be closed)
 */
function closeAnswer(nodeId) {
  document.getElementById(nodeId).remove();

  // if there is no more answe in the popup close the "choiceSharingAnswerPopup" popup
  if (document.querySelectorAll("#choiceSharingAnswerPopupRes .shareRequestAnswers").length == 0)
    closeChoiceSharingAnswerPopup();
}

/**
 * closeChoiceSharingAnswerPopup
 * Closes the "closeChoiceSharingAnswerPopup" popup and resets its content.
 */
function closeChoiceSharingAnswerPopup() {
  $("#choiceSharingAnswerPopup").hide(200);
  document.getElementById("choiceSharingAnswerPopupRes").innerHTML = "";
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
             choiceMade: choiceMade, choice1: shareRequestMsg.questionChoice1,
             choice2: shareRequestMsg.questionChoice2, description: shareRequestMsg.questionDescription};
  connection.send(JSON.stringify(msg));
}

// allows auto focus modal input
$(".modal").on("shown.bs.modal", function() {
  $(this).find("[autofocus]").focus();
});

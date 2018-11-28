
var shareList = [];

/**
 * resetShareModal
 * Resets the share popup's content.
 */
function resetShareModal() {
  shareList = [];
  displayShareList();
  document.getElementById("searchUsersNickname").value = "";
  document.getElementById("usersList").innerHTML = "";
}

/**
 * findUsers
 * Matches usernames with the user's input treated as a regex.
 * Calls the display method for the matched usernames.
 * 
 * @param {String} filter - user's input treated as a regex
 */
function findUsers(filter) {
  // find usernames matching the regex
  const regex = new RegExp(filter.toLowerCase(), 'g');
  let users = usernames.filter(username => username.toLowerCase().match(regex));

  // remove currently logged user's username (one should not share question with himself)
  // if (users.includes(username)) todo
  //   users.splice(users.indexOf(username), 1);

  let listNode = document.getElementById("usersList");
  listNode.innerHTML = "";

  // display matched usernames if there's not too many
  if (users.length < 12)
    displayUsers(users, listNode);
}

/**
 * displayUsers
 * Creates and adds to the DOM elements to display the given usernames list.
 * 
 * @param {Array<String>} users - usernames to display
 * @param {Node} listNode - usernames div container
 */
function displayUsers(users, listNode) {
  users.forEach((username) => {
    let usernameParentNode = document.createElement("div");
    usernameParentNode.onclick = () => addUserToShareList(username);
    usernameParentNode.appendChild(document.createTextNode(username));
    listNode.appendChild(usernameParentNode);
  });
}

/**
 * addUserToShareList
 * Adds the given username to the share list.
 * Calls the display method to update the DOM.
 * 
 * @param {String} username - username to add to the share list
 */
function addUserToShareList(username) {
  if (!shareList.includes(username)) { // if username's not already in the share list
    if (shareList.length < 5) { // limit the number of users to share a question with to 5
      shareList.push(username);
      displayShareList();
    } else
      alert("Sorry, you can share this question whith at most 5 different users.");
  }
}

/**
 * removeUserFromShareList
 * Removes the given username from the share list.
 * Calls the display method to update the DOM.
 * 
 * @param {String} username - username to remove from the share list
 */
function removeUserFromShareList(username) {
  if (shareList.includes(username)) { // if username is in the share list
    shareList.splice(shareList.indexOf(username), 1);
    displayShareList();
  }
}

/**
 * displayShareList
 * Displays the share list content in the "shareWithUserModal" popup.
 */
function displayShareList() {
  let shareListNode = document.getElementById("shareList");
  shareListNode.innerHTML = "";

  // create each username's DOM representation.
  shareList.forEach((username) => {
    let parentNode = document.createElement("span"); // container
    parentNode.appendChild(document.createTextNode(username)); // content (username)
    parentNode.onclick = () => removeUserFromShareList(username);
    shareListNode.appendChild(parentNode); // append to the share list DOM element (div container)
  });

  updateShareButtonStatus();
}

/**
 * updateShareButtonStatus
 * Disables request send button if the share list's empty.
 */
function updateShareButtonStatus() {
  let btn = document.getElementById("btnShareWithUserModal");
  btn.disabled = shareList.length <= 0;
}

/**
 * shareQuestion
 * Sends the current question to the selected users.
 * Closes the "shareWithUserModal" popup.
 */
function shareQuestion() {
  if (userID != -1 && connection != null)
    shareList.forEach(usernameTo => sendShareRequest(usernameTo));
  $('#shareWithUserModal').modal('hide');
}

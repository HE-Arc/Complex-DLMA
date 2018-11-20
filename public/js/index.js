
var shareList = [];

function resetShareModal() {
  shareList = [];
  displayShareList();
  document.getElementById("searchUsersNickname").value = "";
  document.getElementById("usersList").innerHTML = "";
}

function findUsers(filter) {
  const regex = new RegExp(filter.toLowerCase(), 'g');
  let users = usernames.filter(username => username.toLowerCase().match(regex));

  // if (users.includes(username)) todo
  //   users.splice(users.indexOf(username), 1);

  let listNode = document.getElementById("usersList");
  listNode.innerHTML = "";

  if (users.length < 12)
    displayUsers(users, listNode);
}

function displayUsers(users, listNode) {
  users.forEach((username) => {
    let parentNode = document.createElement("div");
    parentNode.onclick = () => addUserToShareList(username);
    parentNode.appendChild(document.createTextNode(username));
    listNode.appendChild(parentNode);
  });
}

function addUserToShareList(username) {
  if (!shareList.includes(username)) {
    if (shareList.length < 5) {
      shareList.push(username);
      displayShareList();
    } else
      alert("Sorry, you can share this question whith maximum 5 different users.");
  }
}

function removeUserFromShareList(username) {
  shareList.splice(shareList.indexOf(username), 1);
  displayShareList();
}

function displayShareList() {
  let shareListNode = document.getElementById("shareList");
  shareListNode.innerHTML = "";

  shareList.forEach((username) => {
    let parentNode = document.createElement("span");
    parentNode.appendChild(document.createTextNode(username));
    parentNode.onclick = () => removeUserFromShareList(username);
    shareListNode.appendChild(parentNode);
  });

  updateShareButtonStatus();
}

function updateShareButtonStatus() {
  let btn = document.getElementById("btnShareWithUserModal");
  btn.disabled = shareList.length <= 0;
}

/*
* Sends the current question to the selected user.
*/
function shareQuestion() {
  if (userID != -1 && connection != null)
    shareList.forEach(usernameTo => sendShareRequest(usernameTo));
  $('#shareWithUserModal').modal('hide');
}


function findUsers(filter) {
  const regex = new RegExp(filter, 'g');
  let users = usernames.filter(username => username.match(regex));
  displayUsers(users);
}

function displayUsers(users) {
  let list = document.getElementById("usersList");
  list.innerHTML = "";
  users.forEach(function(username) {
    let node = document.createElement("div");
    node.appendChild(document.createTextNode(username));
    list.appendChild(node);
  });
}

function getSelectedUser() {

  return -1;
}

/*
* Sends the current question to the selected user.
*/
function shareQuestion() {
  let userToID = getSelectedUser();
  if (userID != -1 && userToID != -1 && connection != null) {
    let msg = {type: "shareQuestion", userFrom: userID, userTo: userToID, question: questionId};
    connection.send(JSON.stringify(msg));
  }
  $('#shareWithUserModal').modal('hide');
}

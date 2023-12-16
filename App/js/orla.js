let usersNotInOrlaRole1;
let usersNotInOrlaRole2;
let role1Users;
let role2Users;
let users;

export async function getUserData() {
  const idOrla = document.getElementById("idOrla").value;
  const url = `/veureOrla?idOrla=${idOrla}`; // Replace with your API endpoint
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    return await response.json();
  } catch (error) {
    console.error("Error fetching user data:", error);
  }
}

export async function printLists() {
  await getUserData()
    .then((data) => {
      users = data;
    })
    .catch((error) => console.error(error));

  usersNotInOrlaRole2 = document.getElementById("usersNotInOrla-role2");
  usersNotInOrlaRole1 = document.getElementById("usersNotInOrla-role1");
  role1Users = document.getElementById("role-1");
  role2Users = document.getElementById("role-2");

  for (let id in users) {
    let userData = users[id];
    if (userData["isInOrla"]) {
      addUserToProperDiv(userData, id);
    } else {
      removeUserToProperDiv(userData, id);
    }
  }
}

export function addUserToOrla(id) {
  const userData = users[id];
  addUserToProperDiv(userData, id);
  const element = document.getElementById(`llista-${id}`);
  element.remove();
  users[id]["isInOrla"] = true;
  console.log(userData["name"]);
}

function addUserToProperDiv(userData, id) {
  if (userData["role"] == 1) {
    role1Users.innerHTML += generarUserOrla(id, userData);
  } else if (userData["role"] == 2) {
    role2Users.innerHTML += generarUserOrla(id, userData);
  }
}

export function removeUserToProperDiv(userData, id) {
  if (userData["role"] == 1) {
    usersNotInOrlaRole1.innerHTML += generarUserLlista(id, userData);
  } else if (userData["role"] == 2) {
    usersNotInOrlaRole2.innerHTML += generarUserLlista(id, userData);
  }
}

function generarUserOrla(id, userData) {
  return `<div id="orla-${id}" onClick="removeUserFromOrla(${id})" style="display: flex; flex-direction: column; align-items: center;">
  <img src="${userData["picture"]}" alt="Foto de ${userData["name"]}">
  <div><p>${userData["name"]}</p></div>
</div>`;
}

function generarUserLlista(id, userData) {
  return `<div id="llista-${id}" onClick="addUserToOrla(${id})" style="display: flex; flex-direction: column; align-items: center;">
  <img src="${userData["picture"]}" alt="Foto de ${userData["name"]}">
  <div><p>${userData["name"]}</p></div>
</div>`;
}

export function removeUserFromOrla(id) {
  const userData = users[id];
  removeUserToProperDiv(userData, id);
  const element = document.getElementById(`orla-${id}`);
  element.remove();
  users[id]["isInOrla"] = false;
}

export function showUsersInfo() {
  console.log(users);
}

export function saveUpdatedOrla() {
  const usersInOrla = Object.keys(users).filter(
    (key) => users[key].isInOrla === 1 || users[key].isInOrla === true
  );
  document.getElementById("orlaValues").value = JSON.stringify(usersInOrla);
  var form = document.getElementById("saveOrla");
  form.submit();
}

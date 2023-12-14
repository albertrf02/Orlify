// TODO move this file to include in bundle.js
let usersNotInOrla;
let role1Users;
let role2Users;
let users;

async function getUserData() {
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

function printLists() {
  // let htmlContentLlista = "";
  // let htmlContentOrla = "";
  // Recorrem totes les cançons de l'array

  usersNotInOrlaRole2 = document.getElementById("usersNotInOrla-role2");
  usersNotInOrlaRole1 = document.getElementById("usersNotInOrla-role1");
  role1Users = document.getElementById("role-1");
  role2Users = document.getElementById("role-2");

  for (let id in users) {
    // Obtenim la informació de cada cançó
    let userData = users[id];
    // Creem una entrada HTML per a cada cançó amb un estil i una funció de clic
    if (userData["isInOrla"]) {
      addUserToProperDiv(userData, id);
    } else {
      removeUserToProperDiv(userData, id);
    }
  }
}

function addUserToOrla(id) {
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

function removeUserToProperDiv(userData, id) {
  if (userData["role"] == 1) {
    usersNotInOrlaRole1.innerHTML += generarUserLlista(id, userData);
  } else if (userData["role"] == 2) {
    usersNotInOrlaRole2.innerHTML += generarUserLlista(id, userData);
  }
}

function generarUserOrla(id, userData) {
  return `<div id="orla-${id}" onClick="removeUserFromOrla(${id})">
        <img src="${userData["picture"]}" alt="Foto de ${userData["name"]}">
        </div>`;
}

function generarUserLlista(id, userData) {
  return `<div id="llista-${id}" onClick="addUserToOrla(${id})" style="display: flex;">
    <img src="${userData["picture"]}" alt="Foto de ${userData["name"]}">
  </div>`;
}

function removeUserFromOrla(id) {
  const userData = users[id];
  removeUserToProperDiv(userData, id);
  const element = document.getElementById(`orla-${id}`);
  element.remove();
  users[id]["isInOrla"] = false;
}

function showUsersInfo() {
  console.log(users);
}

function saveUpdatedOrla() {
  const usersInOrla = Object.keys(users).filter(
    (key) => users[key].isInOrla === 1 || users[key].isInOrla === true
  );
  document.getElementById("orlaValues").value = JSON.stringify(usersInOrla);
  var form = document.getElementById("saveOrla");
  form.submit();
}

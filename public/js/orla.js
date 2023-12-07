// TODO move this file to include in bundle.js
async function getUserData() {
  const idOrla = document.getElementById("idOrla").value;
  const url = `http://localhost:8080/veureOrla?idOrla=${idOrla}`; // Replace with your API endpoint
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
  let htmlContentLlista = "";
  let htmlContentOrla = "";
  // Recorrem totes les cançons de l'array
  for (let id in users) {
    // Obtenim la informació de cada cançó
    let userData = users[id];
    // Creem una entrada HTML per a cada cançó amb un estil i una funció de clic
    if (userData["isInOrla"]) {
      htmlContentOrla += generarUserOrla(id, userData);
    } else {
      htmlContentLlista += generarUserLlista(id, userData);
    }
  }
  // Assignem el contingut HTML creat a l'element "content"
  document.getElementById("content").innerHTML = htmlContentLlista;
  document.getElementById("orla").innerHTML = htmlContentOrla;
}

function addUserToOrla(id) {
  const userData = users[id];
  document.getElementById("orla").innerHTML += generarUserOrla(id, userData);
  const element = document.getElementById(`llista-${id}`);
  element.remove();
  users[id]["isInOrla"] = true;
  console.log(userData["name"]);
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
  const htmlContent = generarUserLlista(id, userData);
  const element = document.getElementById(`orla-${id}`);
  element.remove();
  users[id]["isInOrla"] = false;
  document.getElementById("content").innerHTML += generarUserLlista(
    id,
    userData
  );
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

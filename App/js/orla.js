// Declaració de variables globals
let usersNotInOrlaRole1;
let usersNotInOrlaRole2;
let role1Users;
let role2Users;
let users;

/**
 * Obté les dades dels usuaris mitjançant una crida asíncrona.
 *
 * @return  {Object}  Objecte amb les dades dels usuaris.
 */
export async function getUserData() {
  const idOrla = document.getElementById("idOrla").value;
  const url = `/veureOrla?idOrla=${idOrla}`; // Substitueix amb la teva URL de l'API
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`Error HTTP! Estat: ${response.status}`);
    }
    return await response.json();
  } catch (error) {
    console.error("Error en la recuperació de dades d'usuari:", error);
  }
}

/**
 * Imprimeix les llistes d'usuaris en funció de si estan o no a l'orla.
 */
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

/**
 * Afegeix un usuari a l'orla.
 *
 * @param   {string}  id  Identificador de l'usuari.
 */
export function addUserToOrla(id) {
  const userData = users[id];
  addUserToProperDiv(userData, id);
  const element = document.getElementById(`llista-${id}`);
  element.remove();
  users[id]["isInOrla"] = true;
  console.log(userData["name"]);
}

/**
 * Afegeix un usuari al div corresponent en funció del seu rol.
 *
 * @param   {Object}  userData  Dades de l'usuari.
 * @param   {string}  id        Identificador de l'usuari.
 */
function addUserToProperDiv(userData, id) {
  if (userData["role"] == 1) {
    role1Users.innerHTML += generarUserOrla(id, userData);
  } else if (userData["role"] == 2) {
    role2Users.innerHTML += generarUserOrla(id, userData);
  }
}

/**
 * Elimina un usuari de l'orla.
 *
 * @param   {string}  id  Identificador de l'usuari.
 */
export function removeUserFromOrla(id) {
  const userData = users[id];
  removeUserToProperDiv(userData, id);
  const element = document.getElementById(`orla-${id}`);
  element.remove();
  users[id]["isInOrla"] = false;
}

/**
 * Elimina un usuari del div corresponent en funció del seu rol.
 *
 * @param   {Object}  userData  Dades de l'usuari.
 * @param   {string}  id        Identificador de l'usuari.
 */
export function removeUserToProperDiv(userData, id) {
  if (userData["role"] == 1) {
    usersNotInOrlaRole1.innerHTML += generarUserLlista(id, userData);
  } else if (userData["role"] == 2) {
    usersNotInOrlaRole2.innerHTML += generarUserLlista(id, userData);
  }
}

/**
 * Genera el codi HTML per a un usuari a l'orla.
 *
 * @param   {string}  id        Identificador de l'usuari.
 * @param   {Object}  userData  Dades de l'usuari.
 * @return  {string}            Codi HTML de l'usuari a l'orla.
 */
function generarUserOrla(id, userData) {
  return `<div id="orla-${id}" onClick="removeUserFromOrla(${id})" style="display: flex; flex-direction: column; align-items: center;">
  <img src="${userData["picture"]}" alt="Foto de ${userData["name"]}">
  <div><p>${userData["name"]}</p></div>
</div>`;
}

/**
 * Genera el codi HTML per a un usuari a la llista.
 *
 * @param   {string}  id        Identificador de l'usuari.
 * @param   {Object}  userData  Dades de l'usuari.
 * @return  {string}            Codi HTML de l'usuari a la llista.
 */
function generarUserLlista(id, userData) {
  return `<div id="llista-${id}" onClick="addUserToOrla(${id})" style="display: flex; flex-direction: column; align-items: center;">
  <img src="${userData["picture"]}" alt="Foto de ${userData["name"]}">
  <div><p>${userData["name"]}</p></div>
</div>`;
}

/**
 * Mostra les dades dels usuaris per la consola.
 */
export function showUsersInfo() {
  console.log(users);
}

/**
 * Guarda les dades actualitzades de l'orla.
 */
export function saveUpdatedOrla() {
  const usersInOrla = Object.keys(users).filter(
    (key) => users[key].isInOrla === 1 || users[key].isInOrla === true
  );
  document.getElementById("orlaValues").value = JSON.stringify(usersInOrla);
  var form = document.getElementById("saveOrla");
  form.submit();
}

/**
 * Realitza una crida asíncrona per obtenir el token de carnet.
 *
 * @return  {Promise}  Retorna una promesa amb el token o un error.
 */
async function getCarnetToken() {
  const url = "/carnet-token";

  try {
    // Realitza la crida a la URL amb la funció fetch
    const response = await fetch(url);

    // Comprova si la resposta és vàlida (status 200-299)
    if (!response.ok) {
      throw new Error(`Error HTTP! Estat: ${response.status}`);
    }

    // Retorna el resultat com una promesa resolta amb el contingut JSON
    return await response.json();
  } catch (error) {
    // Captura i gestiona errors en cas que hi hagi problemes amb la crida
    console.error("Error en obtenir dades d'usuari:", error);
  }
}

/**
 * Obté el token de carnet i mostra un alert amb el resultat.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
async function printToken() {
  let token;

  // Espera que es compleixi la promesa getCarnetToken
  await getCarnetToken()
    .then((data) => {
      // Assigna el token obtingut de la promesa
      token = data;
    })
    .catch((error) => console.error(error));

  // Mostra un alert amb el token
  alert(token);
}

export { printToken };
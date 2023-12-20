/**
 * Gestiona el toogle de l'estat públic/privat d'una orla mitjançant una sol·licitud AJAX.
 *
 * @param   {HTMLInputElement}  checkboxPublicOrla  El checkbox que representa l'estat públic/privat de l'orla.
 * @return  {void}                                  No retorna cap valor explícit.
 */
function toggleOrlaPublic(checkboxPublicOrla) {
  // Obtenir l'ID de l'orla i l'estat actual del checkbox
  const idOrla = checkboxPublicOrla.value;
  const isChecked = checkboxPublicOrla.checked;

  // URL de la ruta del servidor on es processarà la sol·licitud AJAX
  const url = "/equipDirectiu";

  // Crear un objecte FormData per enviar dades amb la sol·licitud
  const formData = new FormData();
  formData.append("action", "toggleOrlaPublic");
  formData.append("idOrla", idOrla);
  formData.append("isChecked", isChecked ? 1 : 0);

  // Realitzar la sol·licitud AJAX mitjançant la funció fetch
  fetch(url, {
    method: "POST",         // Utilitzar el mètode POST
    body: formData,         // Enviar les dades amb el format FormData
  })
    .then((response) => {
      // Verificar si la sol·licitud ha estat satisfactòria
      if (!response.ok) {
        throw new Error("Error en la petició");
      }
      // Retornar la resposta en format JSON
      return response.json();
    })
    .then((data) => {
      // És aquí on pots gestionar la resposta correcta de la sol·licitud
      console.log("Toggle success:", data);
    })
    .catch((error) => {
      // Gestionar errors en la sol·licitud
      console.error("Error en la petició", error);
    });
}

export { toggleOrlaPublic };
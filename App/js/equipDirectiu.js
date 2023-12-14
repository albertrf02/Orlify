import $ from "jquery";

function toggleOrlaPublic(checkboxPublicOrla) {
  const idOrla = checkboxPublicOrla.value;
  const isChecked = checkboxPublicOrla.checked;

  const url = "/equipDirectiu";
  const formData = new FormData();
  formData.append("action", "toggleOrlaPublic");
  formData.append("idOrla", idOrla);
  formData.append("isChecked", isChecked ? 1 : 0);

  fetch(url, {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la petició");
      }
      return response.json();
    })
    .then((data) => {
      console.log("Toggle success:", data);
    })
    .catch((error) => {
      console.error("Error en la petició", error);
    });
}

export { toggleOrlaPublic };

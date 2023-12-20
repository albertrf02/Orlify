/**
 * Gestiona l'arrossegament i l'abandonament (drag and drop) de fitxers,
 * així com la selecció de fitxers mitjançant un input de tipus arxiu.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function dragAndDrop() {
    // Obté referències als elements HTML necessaris
    const dropContainer = document.querySelector('.border-dashed');
    const fileInput = document.getElementById('file');
    const fileNamesParagraph = document.getElementById('fileNames');

    // Verifica si l'element dropContainer existeix abans d'establir els esdeveniments
    if (dropContainer) {
        // Esdeveniment d'arrossegament sobre el contenidor
        dropContainer.ondragover = dropContainer.ondragenter = function (evt) {
            evt.preventDefault();
            dropContainer.classList.add('border-blue-500');
        };

        // Esdeveniment d'abandonament de l'arrossegament
        dropContainer.ondragleave = function () {
            dropContainer.classList.remove('border-blue-500');
        };

        // Esdeveniment d'abandonament de l'arrossegament amb fitxers
        dropContainer.ondrop = function (evt) {
            evt.preventDefault();
            dropContainer.classList.remove('border-blue-500');

            // Obtenir la llista de fitxers arrossegats
            const files = evt.dataTransfer.files;

            // Actualitzar el text amb el nombre de fitxers seleccionats
            fileNamesParagraph.textContent = files.length > 1
                ? `${files.length} fitxers seleccionats`
                : files[0].name;

            // Llegir i processar cada fitxer
            for (let i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.readAsText(files[i]);
                // Aquí pots afegir lògica addicional per processar el contingut del fitxer
            }
        };
    }

    // Esdeveniment de canvi en l'input de tipus arxiu
    if (fileInput) {
        fileInput.addEventListener('change', function () {
            // Actualitzar el text amb el nombre de fitxers seleccionats
            fileNamesParagraph.textContent = this.files.length > 1
                ? `${this.files.length} fitxers seleccionats`
                : this.files[0].name;
        });
    }
}

export { dragAndDrop };
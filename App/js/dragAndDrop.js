

function dragAndDrop() {
    const dropContainer = document.querySelector('.border-dashed');
    const fileInput = document.getElementById('file');
    const fileNamesParagraph = document.getElementById('fileNames');

    // Verificar si el elemento dropContainer existe antes de intentar establecer eventos
    if (dropContainer) {
        dropContainer.ondragover = dropContainer.ondragenter = function (evt) {
            evt.preventDefault();
            dropContainer.classList.add('border-blue-500');
        };

        dropContainer.ondragleave = function () {
            dropContainer.classList.remove('border-blue-500');
        };

        dropContainer.ondrop = function (evt) {
            evt.preventDefault();
            dropContainer.classList.remove('border-blue-500');

            const files = evt.dataTransfer.files;

            fileNamesParagraph.textContent = files.length > 1
                ? `${files.length} fitxers seleccionats`
                : files[0].name;

            for (let i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.readAsText(files[i]);
            }
        };
    }

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            fileNamesParagraph.textContent = this.files.length > 1
                ? `${this.files.length} fitxers seleccionats`
                : this.files[0].name;
        });
    }
}


export { dragAndDrop };
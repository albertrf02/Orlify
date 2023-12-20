/**
 * Inicia la càmera web i permet capturar imatges.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function camera() {
    // Espera que el document estigui totalment carregat abans d'iniciar la funció
    document.addEventListener('DOMContentLoaded', function() {
        // Obté elements del DOM utilitzats per la funció
        const video = document.getElementById('videoElement');
        const activateButton = document.getElementById('activateButton');
        const deactivateButton = document.getElementById('deactivateButton');
        const captureButton = document.getElementById('captureButton');
        const imageForm = document.getElementById('imageForm');
        const capturedImageData = document.getElementById('capturedImageData');

        // Variable per emmagatzemar l'objecte de transmissió de la càmera
        let stream;

        // Event listener per activar la càmera
        if (activateButton) {
            activateButton.addEventListener('click', async () => {
                try {
                    // Obtenir l'accés a la càmera mitjançant l'API de mitjans
                    stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    // Assigna el flux de vídeo a l'element de vídeo del DOM
                    video.srcObject = stream;
                    // Mostra el vídeo i els botons relacionats
                    video.classList.remove('hidden');
                    deactivateButton.classList.remove('hidden');
                    activateButton.classList.add('hidden');
                } catch (err) {
                    console.error("Error: " + err);
                }
            });
        }

        // Event listener per desactivar la càmera
        if (deactivateButton) {
            deactivateButton.addEventListener('click', () => {
                // Crida a la funció per aturar la càmera
                stopCamera();
            });
        }

        /**
         * Atura la càmera i amaga els elements relacionats.
         *
         * @return  {void}  No retorna cap valor explícit.
         */
        function stopCamera() {
            if (stream) {
                // Obtenir totes les pistes del flux de la càmera i aturar-les
                const tracks = stream.getTracks();
                tracks.forEach((track) => {
                    track.stop();
                });
            }
            // Reseteja l'element de vídeo i amaga els botons
            video.srcObject = null;
            video.classList.add('hidden');
            deactivateButton.classList.add('hidden');
            activateButton.classList.remove('hidden');
        }

        // Event listener per capturar una imatge
        if (captureButton) {
            captureButton.addEventListener('click', () => {
                // Dimensions del contenidor de la imatge
                const containerWidth = 320;
                const containerHeight = 240;

                // Crea un element canvas per a la manipulació de la imatge
                const canvas = document.createElement('canvas');
                canvas.width = containerWidth;
                canvas.height = containerHeight;

                // Obté el contexte del canvas i copia la imatge del vídeo
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, containerWidth, containerHeight);

                // Converteix la imatge a una URL de dades i assigna a un camp de formulari
                const imageDataURL = canvas.toDataURL('image/png');
                capturedImageData.value = imageDataURL;

                // Envia el formulari amb la imatge capturada
                imageForm.submit();
            });
        }
    });
}

export { camera };
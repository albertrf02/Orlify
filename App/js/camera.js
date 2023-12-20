/**
 * Function that handles the camera
 * @return  {void}  No return value
 */
function camera() {
    /**
     * Listens for the 'DOMContentLoaded' event
     */
    document.addEventListener('DOMContentLoaded', function() {
        // Gets DOM elements
        const video = document.getElementById('videoElement');
        const activateButton = document.getElementById('activateButton');
        const deactivateButton = document.getElementById('deactivateButton');
        const captureButton = document.getElementById('captureButton');
        const imageForm = document.getElementById('imageForm');
        const capturedImageData = document.getElementById('capturedImageData');

        let stream;

        // If the activation button exists
        if (activateButton) {
            activateButton.addEventListener('click', async () => {
                try {
                    // Tries to get the camera stream
                    stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    video.srcObject = stream;
                    video.classList.remove('hidden');
                    deactivateButton.classList.remove('hidden');
                    activateButton.classList.add('hidden');
                } catch (err) {
                    console.error("Error: " + err);
                }
            });
        }

        // If the deactivation button exists
        if (deactivateButton) {
            deactivateButton.addEventListener('click', () => {
                stopCamera();
            });
        }

        /**
         * Function to stop the camera
         * @return  {void}  No return value
         */
        function stopCamera() {
            if (stream) {
                const tracks = stream.getTracks();
                tracks.forEach((track) => {
                    track.stop();
                });
            }
            video.srcObject = null;
            video.classList.add('hidden');
            deactivateButton.classList.add('hidden');
            activateButton.classList.remove('hidden');
        }

        // If the capture button exists
        if (captureButton) {
            captureButton.addEventListener('click', () => {
                const containerWidth = 320;
                const containerHeight = 240;

                const canvas = document.createElement('canvas');
                canvas.width = containerWidth;
                canvas.height = containerHeight;

                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, containerWidth, containerHeight);

                const imageDataURL = canvas.toDataURL('image/png');
                capturedImageData.value = imageDataURL;

                imageForm.submit();
            });
        }
    });
}

export { camera };

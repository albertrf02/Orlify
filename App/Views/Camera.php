<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "Head.php" ?>
    <title>Camera</title>
</head>
<body> 
    <?php require "MenuAdmin.php" ?>
    <div class="flex flex-col items-center h-screen justify-center">
        <!-- Camera display section -->
        <div id="cameraDisplay" class="w-320 h-240 relative mb-1">
            <img id="staticImage" class="rounded-lg" src="../img/camera.jpg" alt="image description" width="360" height="280">
            <!-- Video element for the camera feed, hidden by default -->
            <video id="videoElement" autoplay class="hidden absolute top-0 left-0 w-full h-full object-cover"></video>
        </div>
        <!-- Caption for the camera -->
        <figcaption class="mt-1 text-sm text-center text-gray-500 dark:text-gray-400">Camera caption</figcaption>
        <!-- Buttons to activate/deactivate the camera and capture a photo -->
        <div class="flex justify-center">
            <button id="activateButton" class="mx-2 px-4 py-2 bg-green-500 text-white rounded cursor-pointer">Activar Cámara</button>
            <button id="deactivateButton" class="mx-2 px-4 py-2 bg-red-500 text-white rounded cursor-pointer hidden">Desactivar Cámara</button>
            <button id="captureButton" class="mx-2 px-4 py-2 bg-blue-500 text-white rounded cursor-pointer">Capturar Foto</button>
        </div>
    
        <!-- Container for the captured photos -->
        <div id="capturedPhotos" class="flex justify-center mt-4"></div>

        <!-- Hidden form to submit the captured image data -->
        <form id="imageForm" action="/doinsertphotoweb" method="post" style="display: none;">
            <input type="hidden" id="capturedImageData" name="capturedImageData">
            <input value="<?= $idUser ?>" id="id-edit" name="id-edit" class="hidden">
            <button id="submitImage" name="file" type="submit" style="display: none;"></button>
        </form>

    </div>

    <?php require "Scripts.php" ?>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "Head.php" ?>
    <title>Perfil</title>
</head>

<body>
    <?php require "MenuView.php" ?>

    <div class="container mx-auto my-10 p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- User Information Column -->
            <div class="md:col-span-1 bg-gray-100 p-4 rounded mb-8">
                <h2 class="text-2xl font-bold mb-4">User Information</h2>
                <p>Nom:
                    <?= $_SESSION["user"]["name"] ?>
                </p>
                <p>Cognom:
                    <?= $_SESSION["user"]["surname"] ?>
                </p>
                <p>Email:
                    <?= $_SESSION["user"]["email"] ?>
                    <!-- Add more user information as needed -->
            </div>

            <!-- Images and Orles Column -->
            <div class="md:col-span-1 bg-gray-100 p-4 rounded">
                <!-- User Images Section -->
                <section class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">User Images</h2>
                    <!-- Add user images content here -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($userPhotos as $photo): ?>
                            <div class="bg-white p-4 rounded">
                                <img src="<?= $photo["link"] ?>" alt="photo" class="w-full rounded">
                                <?php if ($photo["defaultPhoto"] == 0): ?>
                                    <form method="POST" action="/perfil?action=setDefaultPhoto">
                                        <input type="hidden" name="idPhoto" value="<?php echo $photo['Id']; ?>">
                                        <button type="submit" class="btn btn-danger">canviar foto per defecte</button>
                                    </form>
                                <?php else: ?>
                                    <p>Foto per defecte</p>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                        <!-- Add more images as needed -->
                </section>
            </div>
        </div>
    </div>

    <?php require "Scripts.php" ?>
</body>

</html>
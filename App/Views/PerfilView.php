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
                <!-- Add user information content here -->
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
                    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 gap-2">
                        <?php foreach ($userPhotos as $photo): ?>
                            <div class="flex flex-col items-center p-2 rounded">
                                <form method="POST" action="/perfil?action=setDefaultPhoto">
                                    <button type="submit" name="idPhoto" value="<?= $photo['id']; ?>"
                                        style="border: none; padding: 0; margin: 0;">
                                        <img src="<?= $photo["link"] ?>" alt="photo" class="h-48 w-48 object-cover rounded"
                                            style="cursor: pointer;">
                                    </button>
                                </form>
                                <?php if ($photo["defaultPhoto"] == 0): ?>
                                    <!-- Add additional styling or content for non-default photos if needed -->
                                <?php else: ?>
                                    <p>Foto per defecte</p>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                    </div>

                </section>
            </div>

        </div>
    </div>

    <?php require "Scripts.php" ?>
</body>

</html>
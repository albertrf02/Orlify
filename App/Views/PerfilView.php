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
                    <img src="path/to/photo1.jpg" alt="Photo 1" class="mb-2">
                    <img src="path/to/photo2.jpg" alt="Photo 2" class="mb-2">
                    <!-- Add more images as needed -->
                </section>

                <!-- Orles Section -->
                <section>
                    <h2 class="text-2xl font-bold mb-4">Orles</h2>
                    <!-- Add content related to orles here -->
                    <p>Orla 1</p>
                    <p>Orla 2</p>
                    <!-- Add more orles as needed -->
                </section>
            </div>
        </div>
    </div>

    <?php require "Scripts.php" ?>
</body>

</html>
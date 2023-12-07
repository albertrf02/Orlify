<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor Orles</title>
    <script src="js/orla.js"></script>
</head>

<body>
    <div class="flex p-4">
        <div class="flex p-4">
            <div id="role-2" class="flex-container"></div>
            <hr style="margin-top: 500px;">
            <div id="role-1" class="flex-container"></div>
            <hr style="margin-top: 500px;">
            <div id="usersNotInOrla" class="flex-container"></div>
        </div>
    </div>
    <button onclick="showUsersInfo()" style="margin-left: 1000px">Mostrar Info</button>
    <form method="post" action="http://localhost:8080/saveOrla?action=saveOrla" id="saveOrla">
        <input type="hidden" id="orlaValues" name="orlaValues" value="">
        <input type="hidden" id="idOrla" name="idOrla" value="<?= $idOrla ?>">
        <input type="button" onclick="saveUpdatedOrla()" id="saveOrlaButton">Guardar Orla</input>
    </form>
</body>


<!-- TODO move styles to main.css -->
<style>
    .flex-container {
        display: flex;
        gap: 20px;
        /* Add a gap between the images */
    }

    #usersNotInOrla,
    #role-1,
    #role-2 {
        flex: 1;
        /* This will make the divs share the available space equally */
    }

    #usersNotInOrla img,
    #role-1 img,
    #role-2 img {
        width: 80px;
        /* Set the width of the images */
        height: auto;
        /* Maintain the aspect ratio */
    }
</style>
<?php require "Scripts.php" ?>
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        getUserData()
            .then((data) => {
                users = data;
                printLists();
            })
            .catch((error) => console.error(error));
    });
</script>

</html>
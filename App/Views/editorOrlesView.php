<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor Orles</title>
    <!-- <?php require "Head.php" ?> -->
    <script src="/js/orla.js"></script>
</head>

<body>
    <!-- <?php require "MenuView.php" ?> -->
    <div class="flex p-4">
        <div class="flex p-4">
            <div id="role-2" class="flex-container"></div>
            <hr style="margin-top: 20px;" id="hr-editOrla1">
            <div id="role-1" class="flex-container"></div>
            <hr style="margin-top: 200px;" id="hr-editOrla2">
            <div id="usersNotInOrla" class="flex-container"></div>
        </div>
    </div>
    <form method="post" action="/saveOrla?action=saveOrla" id="saveOrla">
        <input type="hidden" id="orlaValues" name="orlaValues" value="">
        <input type="hidden" id="idOrla" name="idOrla" value="<?= $idOrla ?>">
        <button type="button" onclick="saveUpdatedOrla()" id="saveOrlaButton">Guardar Orla</button>
    </form>
</body>


<style>
    img {
        width: 100px;
        height: 150px;
        border-radius: 10%;
        object-fit: cover;
        margin: 5px 10px;

    }

    .flex-container {
        display: flex;
        justify-content: center;
    }

    #hr-editOrla1 {
        border: 1px solid #313030;
        width: 1000px;
    }

    #hr-editOrla2 {
        border: 1px solid #313030;
    }

    #saveOrlaButton {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #00A2DC;
        border-radius: 5px;
        cursor: pointer;
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
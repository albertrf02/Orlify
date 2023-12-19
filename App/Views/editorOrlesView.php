<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor Orles</title>
    <!-- <?php require "Head.php" ?> -->
</head>

<body>
    <!-- <?php require "MenuView.php" ?> -->
    <div class="flex p-4">
        <div class="flex p-4">
            <div id="role-2" class="flex-container"></div>
            <hr style="margin-top: 20px;" id="hr-editOrla">
            <div id="role-1" class="flex-container"></div>
            <div id="bottom-div" class="flex-container">
                <div id="usersNotInOrla-role2" class="flex-container"></div>
                <div class="divider"></div>
                <div id="usersNotInOrla-role1" class="flex-container"></div>
                <form method="post" action="/saveOrla?action=saveOrla" id="saveOrla">
                    <input type="hidden" id="orlaValues" name="orlaValues" value="">
                    <input type="hidden" id="idOrla" name="idOrla" value="<?= $idOrla ?>">
                    <button type="button" onclick="saveUpdatedOrla()" id="saveOrlaButton">Guardar Orla</button>
                </form>
            </div>
        </div>
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

    #hr-editOrla {
        border: 1px solid #313030;
        width: 1000px;
    }

    #saveOrlaButton {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #00A2DC;
        border-radius: 5px;
        cursor: pointer;
    }

    .flex-container {
        display: flex;
    }

    .divider {
        border-left: 1px solid #ccc;
        margin-left: 10px;
        padding-left: 10px;
    }

    #role-1 {
        display: flex;
        flex-wrap: wrap;
        max-width: 750px;
        justify-content: center;
        margin: 0 auto;
    }

    #role-2 {
        display: flex;
        flex-wrap: wrap;
        max-width: 500px;
        justify-content: center;
        margin: 0 auto;
    }

    #bottom-div {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #ffffff;
        padding: 10px;
        box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        height: 200px;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
<?php require "Scripts.php" ?>
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        printLists();
    });
</script>

</html>
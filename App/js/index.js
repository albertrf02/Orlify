import { Flowbite } from "../../public/js/flowbite.js";


import { checkPassword } from "./checkPassword.js";
import { editUserModal } from "./ajax.js";
import { deleteUserModal } from "./ajax.js";
import { searchUser } from "./ajax.js";
import { searchUserEquipDirectiu } from "./ajax.js";
import { deleteClassModal } from "./ajax.js";
import { adminPages, equipDirectiuPages, recoverPages} from "./pages.js";
import { dragAndDrop, checkFile } from "./dragAndDrop.js";


adminPages();
checkPassword();
editUserModal();
deleteUserModal();
searchUser();
equipDirectiuPages();
searchUserEquipDirectiu();
recoverPages();
dragAndDrop();
deleteClassModal();

const flowbite = new Flowbite();
flowbite.init(); 

$(document).ready(function() {
    $('#dropdownSearchButton').on('click', function() {
        // Utilizar la función de Flowbite para manejar el desplegable
        flowbite.toggleDropdown('dropdownSearch');
    });
});
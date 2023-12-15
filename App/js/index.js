// Import of functions
import { checkPassword } from "./checkPassword.js";
import { editUserModal } from "./ajax.js";
import { deleteUserModal } from "./ajax.js";
import { searchUser } from "./ajax.js";
import { searchUserEquipDirectiu } from "./ajax.js";
import { adminPages, equipDirectiuPages, recoverPages, teacherPages} from "./pages.js";
import { camera } from "./camera.js";
import { dragAndDrop } from "./dragAndDrop.js";



adminPages();
checkPassword();
editUserModal();
deleteUserModal();
searchUser();
equipDirectiuPages();
searchUserEquipDirectiu();
recoverPages();
teacherPages();
dragAndDrop();
camera(); // da error poner al final

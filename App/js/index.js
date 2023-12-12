

import { checkPassword } from "./checkPassword.js";
import { editUserModal } from "./ajax.js";
import { deleteUserModal } from "./ajax.js";
import { searchUser, searchUserClass } from "./ajax.js";
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
searchUserClass();

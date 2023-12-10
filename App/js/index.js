// Import of functions
import { checkPassword } from "./checkPassword.js";
import { editUserModal } from "./ajax.js";
import { deleteUserModal } from "./ajax.js";
import { searchUser } from "./ajax.js";
import { searchUserEquipDirectiu } from "./ajax.js";
import {
  adminPages,
  equipDirectiuPages,
  recoverPages,
  perfilPages,
} from "./pages.js";
import { dragAndDrop } from "./dragAndDrop.js";

adminPages();
checkPassword();
editUserModal();
deleteUserModal();
searchUser();
equipDirectiuPages();
searchUserEquipDirectiu();
recoverPages();
perfilPages();
dragAndDrop();

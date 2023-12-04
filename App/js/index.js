// Import of functions
import { checkPassword } from "./checkPassword.js";
import { editUserModal } from "./ajax.js";
import { deleteUserModal } from "./ajax.js";
import { searchUser } from "./ajax.js";
import { searchUserEquipDirectiu } from "./ajax.js";
import { adminPages } from "./pages.js";
import { equipDirectiuPages } from "./pages.js";

adminPages();
checkPassword();
editUserModal();
deleteUserModal();
searchUser();
equipDirectiuPages();
searchUserEquipDirectiu();

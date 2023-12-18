import { checkPassword, changePassword } from "./checkPassword.js";
import { editUserModal } from "./ajax.js";
import { deleteUserModal } from "./ajax.js";
import { searchUser, searchUserClass } from "./ajax.js";
import { searchUserEquipDirectiu } from "./ajax.js";
import {
  adminPages,
  equipDirectiuPages,
  recoverPages,
  teacherPages,
  perfilPages,
  toggleFormVisibility,
  showTab,
} from "./pages.js";
import { deleteClassModal } from "./ajax.js";
import { dragAndDrop, checkFile } from "./dragAndDrop.js";
import { toggleOrlaPublic } from "./equipDirectiu.js";
import { camera } from "./camera.js";
import { DatatablesModal } from "./ajax.js";
import { searchUserTeacher } from "./ajax.js";

import * as orla from "./orla.js";


adminPages();
checkPassword();
changePassword();
editUserModal();
deleteUserModal();
searchUser();
equipDirectiuPages();
searchUserEquipDirectiu();
recoverPages();
perfilPages();
window.toggleFormVisibility = toggleFormVisibility;
window.showTab = showTab;
window.toggleOrlaPublic = toggleOrlaPublic;

window.getUserData = orla.getUserData;
window.printLists = orla.printLists;
window.addUserToOrla = orla.addUserToOrla;
window.removeUserFromOrla = orla.removeUserFromOrla;
window.showUsersInfo = orla.showUsersInfo;
window.saveUpdatedOrla = orla.saveUpdatedOrla;


deleteClassModal();
searchUserTeacher();
searchUserClass();
teacherPages();
DatatablesModal();
camera();
dragAndDrop();
checkFile();

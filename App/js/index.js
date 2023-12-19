import { checkPassword, changePassword } from "./checkPassword.js";
import { editUserModal } from "./ajax.js";
import { deleteUserModal } from "./ajax.js";
import { searchUser, searchTeacherClass, searchStudentClass } from "./ajax.js";
import {
  adminPages,
  equipDirectiuPages,
  recoverPages,
  perfilPages,
  toggleFormVisibility,
  showTab,
} from "./pages.js";
import { editUserClass } from "./ajax.js";
import { deleteClassModal } from "./ajax.js";
import { dragAndDrop, checkFile } from "./dragAndDrop.js";
import { toggleOrlaPublic } from "./equipDirectiu.js";
import * as orla from "./orla.js";
import { generateUser } from "./ajax.js";
import { slider } from "./slider.js";

adminPages();
checkPassword();
changePassword();
editUserModal();
deleteUserModal();
searchUser();
equipDirectiuPages();
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

dragAndDrop();
deleteClassModal();
searchTeacherClass();
editUserClass();
generateUser();
searchStudentClass();
slider();


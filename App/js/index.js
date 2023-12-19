import { checkPassword, changePassword } from "./checkPassword.js";
import { editUserModal } from "./ajax.js";
import { deleteUserModal } from "./ajax.js";
import { searchUser, searchTeacherClass, searchStudentClass } from "./ajax.js";
import {
  adminPages,
  equipDirectiuPages,
  recoverPages,
  teacherPages,
  perfilPages,
  toggleFormVisibility,
  showTab,
} from "./pages.js";
import { editUserClass } from "./ajax.js";
import { deleteClassModal } from "./ajax.js";
import { dragAndDrop } from "./dragAndDrop.js";
import { toggleOrlaPublic } from "./equipDirectiu.js";
import { camera } from "./camera.js";
import { DatatablesModal } from "./ajax.js";
import { searchUserTeacher } from "./ajax.js";

import * as orla from "./orla.js";

import * as carnet from "./carnet.js";
import { generateUser } from "./ajax.js";
import { slider } from "./slider.js";
import { cookie } from "./cookie.js";

adminPages();
checkPassword();
changePassword();
editUserModal();
deleteUserModal();
searchUser();
equipDirectiuPages();
recoverPages();
perfilPages();
window.printToken = carnet.printToken;

window.toggleFormVisibility = toggleFormVisibility;
window.showTab = showTab;
window.toggleOrlaPublic = toggleOrlaPublic;

window.getUserData = orla.getUserData;
window.printLists = orla.printLists;
window.addUserToOrla = orla.addUserToOrla;
window.removeUserFromOrla = orla.removeUserFromOrla;
window.showUsersInfo = orla.showUsersInfo;
window.saveUpdatedOrla = orla.saveUpdatedOrla;

cookie();
deleteClassModal();
searchTeacherClass();
editUserClass();
generateUser();
searchStudentClass();

searchUserTeacher();
teacherPages();
DatatablesModal();
camera();
dragAndDrop();
slider();

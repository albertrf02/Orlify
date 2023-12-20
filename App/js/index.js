// Importacions dels mòduls i les funcions
import { checkPassword, changePassword } from "./checkPassword.js";
import { editUserModal, deleteUserModal, searchUser, searchTeacherClass, searchStudentClass, editUserClass, deleteClassModal, DatatablesModal, searchUserTeacher, generateUser } from "./ajax.js";
import { adminPages, equipDirectiuPages, recoverPages, teacherPages, perfilPages, toggleFormVisibility, showTab } from "./pages.js";
import { dragAndDrop } from "./dragAndDrop.js";
import { toggleOrlaPublic } from "./equipDirectiu.js";
import { camera } from "./camera.js";
import * as orla from "./orla.js";
import * as carnet from "./carnet.js";
import { slider } from "./slider.js";
import { cookie } from "./cookie.js";

// Cridades a les funcions o inicialització de les característiques
adminPages();
checkPassword();
changePassword();
editUserModal();
deleteUserModal();
searchUser();
equipDirectiuPages();
recoverPages();
perfilPages();
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

// Exports globals per a l'entorn del navegador
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
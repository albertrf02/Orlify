

import { checkPassword } from "./checkPassword.js";
import { editUserModal } from "./ajax.js";
import { deleteUserModal } from "./ajax.js";
import { searchUser, searchTeacherClass, searchStudentClass } from "./ajax.js";
import { editUserClass } from "./ajax.js";
import { deleteClassModal } from "./ajax.js";
import { adminPages, equipDirectiuPages, recoverPages} from "./pages.js";
import { dragAndDrop, checkFile } from "./dragAndDrop.js";
import { generateUser } from "./ajax.js";
import { slider } from "./slider.js";

adminPages();
checkPassword();
editUserModal();
deleteUserModal();
searchUser();
equipDirectiuPages();
recoverPages();
dragAndDrop();
deleteClassModal();
searchTeacherClass();
editUserClass();
generateUser();
searchStudentClass();
slider();


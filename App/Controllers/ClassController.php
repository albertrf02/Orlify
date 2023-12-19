<?php

namespace App\Controllers;

class ClassController
{

    function editClassAjax($request, $response, $container)
    {

        $classId = $request->get(INPUT_POST, "classId");
        $model2= $container->get("classes");

        $class = $model2->getClass($classId);

        if (!empty($class)) {
            $response->set("class", $class);
            $response->setJSON();
        } else {
            $response->set('error', 'error');
            $response->setJSON();
        }

        return $response;
    }

    function editClass($request, $response, $container)

    {
    $classId = $request->get(INPUT_POST, "id");
    $model2 = $container->get("classes");

    $class = $model2->getClass($classId);
    
    $newState = 1;

    if ($class[0]['state'] === 1) {
        $newState = 0;
    }

    $model2->editClass($classId, $newState);

    $response->redirect("Location: /admin");
    return $response;
}


    function searchTeacherClassAjax ($request, $response, $container) {

        $query = $request->get(INPUT_POST, "query");

        $model = $container->get("users");
        $model2 = $container->get("classes");

        $users = $model2->searchTeacherClassAjax($query);
        $roles = $model->getRoles();
        

        if (!empty($users)) {
            $response->set("users", $users);
            $response->set("roles", $roles);
            $response->setJSON();
        } else {
            $response->set('error', 'error');
            $response->setJSON();
        }

        return $response;

    }


    function searchStudentClassAjax ($request, $response, $container) {

        $query = $request->get(INPUT_POST, "query");

        $model = $container->get("users");
        $model2 = $container->get("classes");

        $users = $model2->searchStudentClassAjax($query);
        $roles = $model->getRoles();
        

        if (!empty($users)) {
            $response->set("users", $users);
            $response->set("roles", $roles);
            $response->setJSON();
        } else {
            $response->set('error', 'error');
            $response->setJSON();
        }

        return $response;

    }

   
    function addUserClass($request, $response, $container) {
        $classId = $_POST['selectedClass'];
        $userIds = $_POST['selectedUsers'];
    
        echo "Class ID: " . $classId . "<br>";
        echo "User IDs: " . implode(", ", $userIds) . "<br>";
    
        if (!is_null($userIds) && is_array($userIds)) {
            $model2 = $container->get("classes");
            $insert = $model2->addUserClass($userIds, $classId);
            echo "funciona";
        } else {
            echo "no funciona";
        }
    
        $response->redirect("Location: /admin");
        return $response;
    }
    

    public function viewUserClass ($request, $response, $container) {

        $classId = $request->get(INPUT_POST, "userClassId");

        $model2 = $container->get("classes");

        $usersClass = $model2->getUsersByClassId($classId);

        $count0 = 0;
        if (!empty($usersClass)) {
            $response->set("usersClass", $usersClass);
            $response->setJSON();
        } else {
            $response->set('usersClass', $count0);
            $response->setJSON();
        }


        return $response;
    }
    

   public function deleteUserClass ($request, $response, $container) {

    $userIds = $_POST['selectedUsersClass'];
    $classId = $request->get(INPUT_POST, "userClassId");


        if (!is_null($userIds) && is_array($userIds)) {
            $model2 = $container->get("classes");
            $insert = $model2->deleteUserClass($userIds, $classId);
            echo "funciona";
        } else {
            echo "no funciona";
        }
    
        $response->redirect("Location: /admin");

        return $response;
        

   }


   public function addClass ($request, $response, $container) {

    $className = $request->get(INPUT_POST, "class");

    $model2 = $container->get("classes");

     $insert = $model2->addClass($className);

     $response->redirect("Location: /admin");

    return $response;




   }


    public function getClassAjax($request, $response, $container)
    {
        $idClass = $request->get(INPUT_POST, "idClass");

        $model = $container->get("classes");
        $users = $model->getUsersByClass($idClass);

        if (!empty($users)) {
            $response->set('users', $users);
            $response->setJSON();
        } else {
            $response->set('error', 'error');
            $response->setJSON();
        }

        return $response;
    }
    



    

}


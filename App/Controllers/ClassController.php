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

    // Retrieve the current class state
    $class = $model2->getClass($classId);
    
    $newState = 1;

    if ($class[0]['state'] === 1) {
        $newState = 0;
    }

    $model2->editClass($classId, $newState);

    $response->redirect("Location: /admin");
    return $response;
}


    function searchUserClassAjax ($request, $response, $container) {

        $query = $request->get(INPUT_POST, "query");

        $model = $container->get("users");
        $model2 = $container->get("classes");

        $users = $model2->searchUserClassAjax($query);
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
    
        return $response;
    }
    
    
    



    

}


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






    



    

}


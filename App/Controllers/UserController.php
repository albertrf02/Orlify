<?php

namespace App\Controllers;

class UserController {

    public function update($request, $response, $container) {

        $id = $request->get(INPUT_POST, "id");

        $name = $request->get(INPUT_POST, "name");
        $surname = $request->get(INPUT_POST, "surname");
        $username = $request->get(INPUT_POST, "username");

        $password = $request->get(INPUT_POST, "password");
        $email = $request->get(INPUT_POST, "email");

        $role = $request->get(INPUT_POST, "role");


        

        $model = $container->get("users");

        $hashPassword = $model->hashPassword($password);

        $update = $model->updateUser($id, $name, $surname, $username, $hashPassword, $email, $role);

        $response->redirect("Location: /admin");

        


        
        return $response;
    }

    public function delete($request, $response, $container) {

        $id = $request->get(INPUT_POST, "id");

        $model = $container->get("users");

        $delete = $model->deleteUser($id);

        $response->redirect("Location: /admin");
        
        return $response;
    }




    
    
}


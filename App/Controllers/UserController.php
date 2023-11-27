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

    public function searchUserAjax($request, $response, $container) {
        
        $query = $request->get(INPUT_POST, "query");
    
        $model = $container->get("users");
        $newUsers = $model->searchUserAjax($query);
    
        if (!empty($newUsers)) {
            $response->set('users', $newUsers);
            $response->setJSON();
        } else {
            $response->set('error', 'error');
            $response->setJSON();
        }
    
        return $response;
    }


    public function updateAjax($request, $response, $container) {

        $userId = $request->get(INPUT_POST, "userId");

        $model = $container->get("users");
        $infoUser = $model->getUserById($userId);
        $roles = $model->getRoles();

        if (!empty($infoUser)) {
            $response->set('user', $infoUser);
            $response->set('roles', $roles);
            $response->setJSON();
        } else {
            $response->set ('error', 'error');
            $response->setJSON();
        }
    
        return $response;
    }

    public function deleteAjax($request, $response, $container) {

        $userId = $request->get(INPUT_POST, "userId");

        $model = $container->get("users");
        $infoUser = $model->getUserById($userId);

        if (!empty($infoUser)) {
            $response->set('user', $infoUser);
            $response->setJSON();
        } else {
            $response->set ('error', 'error');
            $response->setJSON();
        }
    
        return $response;
    }




    
    
}


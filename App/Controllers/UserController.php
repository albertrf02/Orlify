<?php

namespace App\Controllers;

class UserController {

    public function update($request, $response, $container) {

        $id = $request->get(INPUT_POST, "id");
        $name = $request->get(INPUT_POST, "name");
        $surname = $request->get(INPUT_POST, "surname");
        $password = $request->get(INPUT_POST, "password");
        $role = $request->get(INPUT_POST, "role");
        $email = $request->get(INPUT_POST, "email");

        $model = $container->get("users");

        $checkPassword = $model->getUser($email);

        if ($password === $checkPassword['password']) {
            $update = $model->updateUser($id, $name, $surname, $password, $role);
        } else {
            $hashPassword = $model->hashPassword($password);
            $update = $model->updateUser($id, $name, $surname, $hashPassword, $role);
        }

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

        $countUsers = 9;
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page'] > 0 ? $_REQUEST['page'] : 1;
        $start = ($page - 1) * $countUsers;
        $users = array_slice($newUsers, $start, $countUsers);
        $totalPages = ceil(count($newUsers) / $countUsers);

        $response->set("users", $users);
        $response->set("currentPage", $page);
        $response->set("totalPages", $totalPages);
    
        if (!empty($newUsers)) {
            $response->set("users", $users);
            $response->set("currentPage", $page);
            $response->set("totalPages", $totalPages);
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


    public function importCSV($request, $response, $container) {
        $fileCSV = $_FILES['file'];
    
        // Check if a file was uploaded
        if (!empty($fileCSV['name'])) {
            // Validate file type
            $allowedMimes = array('text/csv', 'application/csv', 'application/vnd.ms-excel');
    
            if (in_array($fileCSV['type'], $allowedMimes)) {
                // Process CSV file
                $csvFile = fopen($fileCSV['tmp_name'], 'r');
    
                // Skip the first line (header) of the CSV file
                $header = fgetcsv($csvFile);
    
                while (($userData = fgetcsv($csvFile)) !== FALSE) {
                    // Assuming CSV columns match the order of parameters in your insert method
                    list($name, $surname, $username, $password, $email, $avatar) = $userData;
    
                    $model = $container->get("users");
    
                    // Hash the password using your hashPassword method
                    $hashedPassword = $model->hashPassword($password);
    
                    // Insert data into the database using the model's insert method
                    $insert = $model->insert($name, $surname, $username, $hashedPassword, $email, $avatar);
                }
    
                fclose($csvFile);
    
                // Redirect after processing CSV
                $response->redirect("Location: /admin");
                return $response;
            }
        }
    }
    
    
}


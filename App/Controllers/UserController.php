<?php

namespace App\Controllers;

class UserController
{

    public function update($request, $response, $container)
    {
        $id = $request->get(INPUT_POST, "id-edit");
        $name = $request->get(INPUT_POST, "name-edit");
        $surname = $request->get(INPUT_POST, "surname-edit");
        $password = $request->get(INPUT_POST, "password-edit");
        $role = $request->get(INPUT_POST, "role-edit");
        $email = $request->get(INPUT_POST, "email-edit");
    
        $model = $container->get("users");
    
        $currentUser = $model->getUser($email);
    
        $name = !empty($name) ? $name : $currentUser['name'];
        $surname = !empty($surname) ? $surname : $currentUser['surname'];
        $role = !empty($role) ? $role : $currentUser['role'];
    
        if (!empty($password)) {
            $hashPassword = $model->hashPassword($password);
        } else {
            $hashPassword = $currentUser['password'];
        }
    
        $update = $model->updateUser($id, $name, $surname, $hashPassword, $role);
    
        $response->redirect("Location: /admin");

        return $response;
    }



    

    public function delete($request, $response, $container)
    {

        $id = $request->get(INPUT_POST, "id");

        $model = $container->get("users");
        $delete = $model->deleteUser($id);

        $response->redirect("Location: /admin");
        return $response;
    }

    public function searchUserAjax($request, $response, $container)
    {

        $query = $request->get(INPUT_POST, "query");

        $model = $container->get("users");
        $newUsers = $model->searchUserAjax($query);

        $student = $model->searchUserStudentAjax($query);

        $countUsers = 12;
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page'] > 0 ? $_REQUEST['page'] : 1;
        $start = ($page - 1) * $countUsers;
        $users = array_slice($newUsers, $start, $countUsers);
        $totalPages = ceil(count($newUsers) / $countUsers);


        if (!empty($newUsers)) {
            $response->set("users", $users);
            $response->set("student", $student);
            $response->set("currentPage", $page);
            $response->set("totalPages", $totalPages);
            $response->setJSON();
        } else {
            $response->set('error', 'error');
            $response->setJSON();
        }

        return $response;
    }


    public function updateAjax($request, $response, $container)
    {

        $userId = $request->get(INPUT_POST, "userId");

        $model = $container->get("users");
        $infoUser = $model->getUserById($userId);
        $roles = $model->getRoles();

        if (!empty($infoUser)) {
            $response->set('user', $infoUser);
            $response->set('roles', $roles);
            $response->setJSON();
        } else {
            $response->set('error', 'error');
            $response->setJSON();
        }

        return $response;
    }

    public function deleteAjax($request, $response, $container)
    {

        $userId = $request->get(INPUT_POST, "userId");

        $model = $container->get("users");
        $infoUser = $model->getUserById($userId);

        if (!empty($infoUser)) {
            $response->set('user', $infoUser);
            $response->setJSON();
        } else {
            $response->set('error', 'error');
            $response->setJSON();
        }

        return $response;
    }

    public function reportImages($request, $response, $container)
    {
        $model = $container->get("users");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPhoto = $_POST["idPhoto"];
            $postPhoto = $model->insertReport($idPhoto);

            $response->set("postPhoto", $postPhoto);
            header("Location: /perfil");
        }


        $response->SetTemplate("perfilView.php");
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


    public function insertGeneratedUser($request, $response, $container) {
        $jsonPayload = file_get_contents("php://input");

        // Decodificar el JSON a un array asociativo
        $generatedUser = json_decode($jsonPayload, true);
    
        // Acceder a los valores
        $name = $generatedUser['name'];
        $surname = $generatedUser['surname'];
        $username = $generatedUser['username'];
        $password = $generatedUser['password'];
        $email = $generatedUser['email'];
        $role = $generatedUser['role'];
    
    
        // Por ejemplo, puedes insertar estos valores en la base de datos
        $model = $container->get("users");

        $hashPassword = $model->hashPassword($password);

        $insert = $model->insertGeneratedUser($name, $surname, $username, $hashPassword, $email, $role);

        $user = $model->getUser($email);

        $roles = $model->getRoles();

        if ($user) {
            $response->set('user', $user);
            $response->set('roles', $roles);
            $response->setJSON();       
        }

        return $response;


    }





    
    public function insertPhoto($request, $response, $container)
{
    // Get the user ID from the request
    $idUser = $request->get(INPUT_POST, "id-edit");
    
    // Define the folder path where the photo will be stored
    $folder = "../public/img/" . $idUser . "/";
    
    // If the folder doesn't exist, create it
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }
    
    // Get the name of the uploaded file
    $fileName = basename($_FILES['file']['name']);
    // Define the complete file path where the photo will be stored
    $uploadFile = $folder . $fileName;
    
    // Move the uploaded file to the desired location
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);

    // Define the path that will be stored in the database
    $linkBDD = "../img/" . $idUser . "/" . $fileName;

    // Get the users model
    $model = $container->get("users");
    // Insert the photo into the database
    $model->insertPhotoByID($linkBDD, $idUser);

    // Redirect to the professor page
    $response->redirect("Location: /professor");
    return $response;
}
    

public function insertPhotoWeb($request, $response, $container)
{   
    // Get the user ID from the request
    $idUser = $request->get(INPUT_POST, "id-edit");
    // Get the link of the photo from the request
    $link = $_POST['capturedImageData'];

    // Define the folder path where the photo will be stored
    $folder = "../public/img/" . $idUser . "/";
    // If the folder doesn't exist, create it
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    // Get the current time in 'YmdHis' format 
    $timestamp = date('YmdHis'); 
    // Define the name of the photo file
    $fileName = 'captured_image_' . $timestamp . '.png';
    // Define the complete file path where the photo will be stored
    $destinationPath = $folder . $fileName; 
    // Save the photo to the specified path
    file_put_contents($destinationPath, file_get_contents($link));

    // Define the path that will be stored in the database
    $linkBDD = "../img/" . $idUser . "/" . $fileName;

    // Get the users model
    $model = $container->get("users");
    // Insert the photo into the database
    $model->insertPhotoByID($linkBDD, $idUser);

    // Redirect to the professor page
    $response->redirect("Location: /professor");
    return $response;
}


    
}


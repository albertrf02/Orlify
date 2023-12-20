<?php

namespace App\Controllers;

class UserController
{

    /**
     * Actualitza les dades de l'usuari a la base de dades.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades a actualitzar.
     * @param \Emeset\Http\Response $response Resposta HTTP per gestionar el redirigiment després de l'actualització.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP que redirigeix a la pàgina d'administració després de l'actualització.
     */
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

    /**
     * Elimina un usuari de la base de dades.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb la informació de l'usuari a eliminar.
     * @param \Emeset\Http\Response $response Resposta HTTP per gestionar el redirigiment després de l'eliminació.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP que redirigeix a la pàgina d'administració després de l'eliminació.
     */
    public function delete($request, $response, $container)
    {

        $id = $request->get(INPUT_POST, "id");

        $model = $container->get("users");
        $delete = $model->deleteUser($id);

        $response->redirect("Location: /admin");
        return $response;
    }

    /**
     * Realitza una cerca d'usuaris i estudiants mitjançant una crida AJAX.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb el terme de cerca i informació de paginació.
     * @param \Emeset\Http\Response $response Resposta HTTP que contindrà els resultats de la cerca i informació de paginació.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb els resultats de la cerca i informació de paginació en format JSON.
     */
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

    /**
     * Obté la informació d'un usuari per a l'actualització mitjançant una crida AJAX.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb l'identificador de l'usuari.
     * @param \Emeset\Http\Response $response Resposta HTTP que contindrà la informació de l'usuari i els rols disponibles.
     * @param \Emeset\Container $container 
     *
     * @return \Emeset\Http\Response Resposta HTTP amb la informació de l'usuari i els rols disponibles en format JSON.
     */
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

    /**
     * Obté la informació d'un usuari abans de la seva eliminació mitjançant una crida AJAX.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb l'identificador de l'usuari.
     * @param \Emeset\Http\Response $response Resposta HTTP que contindrà la informació de l'usuari en format JSON.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb la informació de l'usuari en format JSON.
     */
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

    /**
     * Gestiona els informes d'imatges.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb les dades de l'informe o redirecció a la pàgina de perfil.
     */
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

    /**
     * Importa dades d'usuaris des d'un fitxer CSV i les insereix a la base de dades.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb el fitxer CSV a processar.
     * @param \Emeset\Http\Response $response Resposta HTTP amb la redirecció a l'arribar al final del procés.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb la redirecció a l'arribar al final del procés.
     */
    public function importCSV($request, $response, $container)
    {

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

    /**
     * Inserta un usuari generat a partir de un payload JSON en la base de datos.
     *
     * @param \Emeset\Http\Request $request Petició HTTP con el payload JSON.
     * @param \Emeset\Http\Response $response Respuesta HTTP con el usuari insertat y roles.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Respuesta HTTP con el usuari insertat y rols en formatt JSON.
     */
    public function insertGeneratedUser($request, $response, $container)
    {
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

    /**
     * Inserta una foto asociada a un usuari en la base de dades y en la carpeta de imatges.
     *
     * @param \Emeset\Http\Request $request Petició HTTP con los datos de la foto.
     * @param \Emeset\Http\Response $response Resposta HTTP con la redirecció a la página del profesor.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP con la redirecció a la página del profesor.
     */
    public function insertPhoto($request, $response, $container)
    {
        $idUser = $request->get(INPUT_POST, "id-edit");

        $carpeta = "../public/img/" . $idUser . "/";

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $fileName = basename($_FILES['file']['name']);
        $uploadFile = $carpeta . $fileName;

        move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);

        $linkBDD = "../img/" . $idUser . "/" . $fileName;

        $model = $container->get("users");
        $model->insertPhotoByID($linkBDD, $idUser);

        $response->redirect("Location: /professor");
        return $response;
    }

    /**
     * Inserta una foto capturada desde la web asociada a un usuari en la base de dades y en la carpeta de imatges.
     *
     * @param \Emeset\Http\Request $request Petició HTTP con los datos de la foto.
     * @param \Emeset\Http\Response $response Resposta HTTP con la redirecció a la página del profesor.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Respuesta HTTP con la redirecció a la página del profesor.
     */
    public function insertPhotoWeb($request, $response, $container)
    {
        $idUser = $request->get(INPUT_POST, "id-edit");
        $link = $_POST['capturedImageData'];

        $carpeta = "../public/img/" . $idUser . "/";
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $timestamp = date('YmdHis');
        $nombreArchivo = 'captured_image_' . $timestamp . '.png';
        $rutaDestino = $carpeta . $nombreArchivo;
        file_put_contents($rutaDestino, file_get_contents($link));


        $linkBDD = "../img/" . $idUser . "/" . $nombreArchivo;

        $model = $container->get("users");
        $model->insertPhotoByID($linkBDD, $idUser);

        $response->redirect("Location: /professor");
        return $response;
    }


}


<?php

namespace App\Controllers;

class ClassController
{

    /**
     * Gestiona la sol·licitud AJAX per obtenir les dades d'una classe específica per a l'edició.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades de la sol·licitud.
     * @param \Emeset\Http\Response $response Resposta HTTP per enviar les dades de resposta.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb les dades de la classe o error en format JSON.
     */
    function editClassAjax($request, $response, $container)
    {

        $classId = $request->get(INPUT_POST, "classId");
        $model2 = $container->get("classes");

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

    /**
     * Gestiona l'edició de l'estat d'una classe i redirigeix a la pàgina d'administració.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades de la sol·licitud.
     * @param \Emeset\Http\Response $response Resposta HTTP per redirigir a una altra pàgina.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP de redirecció a la pàgina d'administració.
     */
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


    /**
     * Gestiona la sol·licitud AJAX per cercar professors a partir d'una consulta de cerca i retorna les dades corresponents.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades de la sol·licitud.
     * @param \Emeset\Http\Response $response Resposta HTTP per enviar les dades de resposta.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb les dades dels professors que coincideixen amb la cerca o error en format JSON.
     */
    function searchTeacherClassAjax($request, $response, $container)
    {

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

    /**
     * Gestiona la sol·licitud AJAX per cercar estudiants a partir d'una consulta de cerca i retorna les dades corresponents.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades de la sol·licitud.
     * @param \Emeset\Http\Response $response Resposta HTTP per enviar les dades de resposta.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb les dades dels estudiants que coincideixen amb la cerca o error en format JSON.
     */
    function searchStudentClassAjax($request, $response, $container)
    {

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


    /**
     * Gestiona l'addició d'usuaris a una classe i redirigeix a la pàgina d'administració.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades de la sol·licitud.
     * @param \Emeset\Http\Response $response Resposta HTTP per redirigir a una altra pàgina.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP de redirecció a la pàgina d'administració.
     */
    function addUserClass($request, $response, $container)
    {
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

    /**
     * Mostra els usuaris associats a una classe mitjançant una sol·licitud AJAX.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades de la sol·licitud.
     * @param \Emeset\Http\Response $response Resposta HTTP per enviar les dades de resposta.
     * @param \Emeset\Container $container 
     *
     * @return \Emeset\Http\Response Resposta HTTP amb les dades dels usuaris de la classe o el nombre d'usuaris igual a 0 en format JSON.
     */
    public function viewUserClass($request, $response, $container)
    {

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

    /**
     * Elimina usuaris d'una classe i redirigeix a la pàgina d'administració.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades de la sol·licitud.
     * @param \Emeset\Http\Response $response Resposta HTTP per redirigir a una altra pàgina.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP de redirecció a la pàgina d'administració.
     */
    public function deleteUserClass($request, $response, $container)
    {

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

    /**
     * Afegeix una nova classe i redirigeix a la pàgina d'administració.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades de la sol·licitud.
     * @param \Emeset\Http\Response $response Resposta HTTP per redirigir a una altra pàgina.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP de redirecció a la pàgina d'administració.
     */
    public function addClass($request, $response, $container)
    {

        $className = $request->get(INPUT_POST, "class");

        $model2 = $container->get("classes");

        $insert = $model2->addClass($className);

        $response->redirect("Location: /admin");

        return $response;

    }


    /**
     * Obté els usuaris d'una classe mitjançant una sol·licitud AJAX i retorna una resposta JSON.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades de la sol·licitud.
     * @param \Emeset\Http\Response $response Resposta HTTP per enviar les dades JSON.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb dades JSON que contenen els usuaris de la classe.
     */
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


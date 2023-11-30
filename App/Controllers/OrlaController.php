<?php

namespace App\Controllers;

class OrlaController
{

    public function getUsersFromOrla($request, $response, $container)
    {
        $orlesModel = $container->get("orles");

        $usersInOrla = $orlesModel->getUserFromGroupInOrla(1, 1);
        $placeholderImage = 'https://cdn4.vectorstock.com/i/1000x1000/82/33/person-gray-photo-placeholder-woman-vector-24138233.jpg';

        // Transform the array
        $usersInOrlaMap = [];
        foreach ($usersInOrla as $item) {
            $usersInOrlaMap[$item['id']] = [
                'name' => $item['name'] . ' ' . $item['surname'], // Combining first and last name
                'picture' => $item['defaultPicture'] ?? $placeholderImage, // Use default picture if available, else placeholder
                'isInOrla' => $item['isInOrla'] ?? false // Use isInOrla if available, else false
            ];
        }

        $response->setJSON();
        $response->setBody(json_encode($usersInOrlaMap));

        return $response;
    }

}
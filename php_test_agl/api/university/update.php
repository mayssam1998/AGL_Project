<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
    

    include_once '../../config/Database.php';
    include_once '../../models/University.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Intantiate university object
    $university = new University($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID
    $university->id = $data->id;
    $university->name = $data->name;
    $university->city_id = $data->city_id;
    $university->email = $data->email;
    $university->telephone_number = $data->telephone_number;
    $university->website = $data->website;
    $university->password = $data->password;

    // Update university
    if($university->update()){
        echo json_encode(
            array('message' => 'University Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'University Not Updated')
        );
    }
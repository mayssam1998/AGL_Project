<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
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

    // Delete university
    if($university->delete()){
        echo json_encode(
            array('message' => 'University Deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'University Not Deleted')
        );
    }
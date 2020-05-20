<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
    

    include_once '../../config/Database.php';
    include_once '../../models/Skill.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Intantiate skill object
    $skill = new Skill($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));
 
    $skill->description = $data->description;

    // Create skill
    if($skill->create()){
        echo json_encode(
            array('message' => 'Skill Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Skill Not Created')
        );
    }
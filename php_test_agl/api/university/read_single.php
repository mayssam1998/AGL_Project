<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
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

    // Get University
    $university->read_single();

    // Create array
    $university = array(
        'id'=> $university->id,
        'name'=> $university->name ,
        'city_id'=> $university->city_id,
        'city_name'=> $university->city_name,
        'email'=> $university->email,
        'telephone_number'=> $university->telephone_number,
        'password'=> $university->password,
        'website'=> $university->website,
    );

    //Make JSON
    print_r(json_encode($university));

    ?>
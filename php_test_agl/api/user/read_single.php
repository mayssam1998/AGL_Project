<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Intantiate user object
    $user = new User($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID
    $user->id = $data->id;

    // Get User
    $user->read_single();

    // Create array
    $user = array(
        'id'=> $user->id,
        'first_name'=> $user->first_name,
        'last_name'=> $user->last_name,
        'email'=> $user->email,
        'university_id'=> $user->university_id,
        'university_name'=> $user->university_name,
        'city_id'=> $user->city_id,
        'city_name'=> $user->city_name,
        'date_of_birth'=> $user->date_of_birth,
        'password'=> $user->password,
        'skills'=> $user->skills
    );

    //Make JSON
    print_r(json_encode($user));

    ?>
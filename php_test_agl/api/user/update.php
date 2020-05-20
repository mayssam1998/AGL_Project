<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
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

    // Get raw posted data as assoc array
    $data_assoc = json_decode(file_get_contents("php://input"),true);

    // Set ID
    $user->id = $data->id;
    $user->first_name = $data->first_name;
    $user->last_name = $data->last_name;
    $user->email = $data->email;
    $user->university_id = $data->university_id;
    $user->city_id = $data->city_id;
    $user->date_of_birth = $data->date_of_birth;
    $user->password = $data->password;

    // Update user
    if($user->update()){

        foreach($data_assoc['skills_added'] as $key => $value){
            $params = array();
            foreach($value as $value1){
                    array_push($params,$value1);
            }
            $user->insertUserSkill($params[0],$params[1]);
        }
        foreach($data_assoc['skills_removed'] as $key => $value){
            foreach($value as $value1){
                    $user->deleteUserSkill($value1);
            }
        }

        echo json_encode(
            array('message' => 'User Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'User Not Updated')
        );
    }
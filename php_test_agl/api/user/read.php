<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json;charset=UTF-8');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Intantiate user object
    $user = new User($db);

    // user query
    $result = $user->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any users
    if($num > 0){
        $users_arr = array();
        $users_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $user_item = array(

                'id'=> $id,
                'first_name'=> $first_name,
                'last_name'=> $last_name,
                'email'=> $email,
                'university_id'=> $university_id,
                'university_name'=> $university_name,
                'city_id'=> $city_id,
                'city_name'=> $city_name,
                'date_of_birth'=> $date_of_birth,
                'password'=> $password,
                'skills'=> $user->getUserSkills($id)

            );

            // Push to "data"
            array_push($users_arr['data'],$user_item);
        }
		
		// Turn to JSON & output
        echo json_encode($users_arr, JSON_UNESCAPED_UNICODE);
		
		
    } else {
        // NO Users
        echo json_encode(
            array('message' => 'No Users Found'));
    }
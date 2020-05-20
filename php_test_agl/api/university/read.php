<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/University.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Intantiate university object
    $university = new University($db);

    // university query
    $result = $university->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any universities
    if($num > 0){
        $universities_arr = array();
        $universities_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $university_item = array(

                'id'=> $id,
                'name'=> $name,
                'city_id'=> $city_id,
                'city_name'=> $city_name,
                'email'=> $email,
                'telephone_number'=> $telephone_number,
                'password'=> $password,
                'website'=> $website

            );

            // Push to "data"
            array_push($universities_arr['data'],$university_item);
        }

        // Turn to JSON & output
        echo json_encode($universities_arr);
    } else {
        // NO Universities
        echo json_encode(
            array('message' => 'No Universities Found'));
    }
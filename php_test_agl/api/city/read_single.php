<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/City.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Intantiate city object
    $city = new City($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID
    $city->id = $data->id;

    // Get City
    $city->read_single();

    // Create array
    $city = array(
        'id'=> $city->id,
        'name'=> $city->name,
        'country_id'=> $city->country_id,
        'country_name'=> $city->country_name,
        'gouvernat_id'=> $city->gouvernat_id,
        'gouvernat_name'=> $city->gouvernat_name,
        'district_id'=> $city->district_id,
        'district_name'=> $city->district_name,
        'centroid'=> $city->centroid,
        'polygon'=> $city->polygon
    );

    //Make JSON
    print_r(json_encode($city));

    ?>
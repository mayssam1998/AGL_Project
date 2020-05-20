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
    $skill_id = $data->id;
    $k = $data->k;

    // city query
    $result = $city->readTopK($skill_id,$k);

    // Get row count
    $num = $result->rowCount();

    // Check if any cities
    if($num > 0){
        $cities_arr = array();
        $cities_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $city_item = array(

                'id'=> $id,
                'name'=> $name,
                'country_id'=> $country_id,
                'country_name'=> $country_name,
                'gouvernat_id'=> $gouvernat_id,
                'gouvernat_name'=> $gouvernat_name,
                'district_id'=> $district_id,
                'district_name'=> $district_name,
                'centroid'=> json_decode($centroid,true)['coordinates'],
                'skill_id'=> $skill_id,
                'total' => $total,
                //'polygon'=> json_decode($polygon,true)['coordinates']
                

            );

            // Push to "data"
            array_push($cities_arr['data'],$city_item);
        }

        // Turn to JSON & output
        echo json_encode($cities_arr);
    } else {
        // NO Cities
        echo json_encode(
            array('message' => 'No Cities Found'));
    }
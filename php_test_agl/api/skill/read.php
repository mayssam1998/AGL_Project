<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
	header('Access-Control-Allow-Credentials: true');

    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Skill.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Intantiate skill object
    $skill = new Skill($db);

    // skill query
    $result = $skill->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any skills
    if($num > 0){
        $skills_arr = array();
        $skills_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $skill_item = array(

                'id'=> $id,
                'description'=> $description

            );

            // Push to "data"
            array_push($skills_arr['data'],$skill_item);
        }

        // Turn to JSON & output
        echo json_encode($skills_arr);
    } else {
        // NO Skills
        echo json_encode(
            array('message' => 'No Skills Found'));
    }
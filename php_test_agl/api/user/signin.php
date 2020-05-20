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

    // Get email and password from user
    $email = $data->email;
    $password = $data->password;

    // Get id and password from db
    $result = $user->getUserFromEmail($email);
    // Get row count
    $num = $result->rowCount();

    if($num >0){
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $user->id = $row['id'];
        $db_password = $row['password'];

        // Comparing the two passwords

        if($password==$db_password){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/php_test_agl/api/user/read_single.php" );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{ "id": ' . $user->id . ' }' ); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
            echo curl_exec ($ch);
        } else {
            echo json_encode(
                array('message' => 'Wrong Password')
            );
        }

    }else {
        echo json_encode(
            array('message' => 'Wrong Email')
        );
    }

    ?>
<?php

    class Database {
    
        //DB Params
        private $host = 'localhost';
        private $db_name = 'test_agl';
        private $username = 'root';
        private $password = '';
        private $conn;
        
        
        
        //DB Connect
        public function connect(){
            $this->conn = null;

            try{

                $this->conn = new PDO('mysql:host=' . $this->host . ';dname= ' . $this->db_name.';charset=utf8',
                $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            }catch(PDOException $e){
                echo "Connection Error: " . $e->getMessage();
            }
            return $this->conn;
        }
    
    }
    
    
?>
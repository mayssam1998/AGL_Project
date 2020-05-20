<?php

     header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
	header('Access-Control-Allow-Credentials: true');	

    class Skill {

        //DB Stuff
        private $conn;
        private $table = 'skills';

        //Skill Properties
        public $id;
        public $description;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }


        // Get all Skills
        public function read()
        {
            // Create query
            $query = 'SELECT s.id, 
                        s.Description as description
                    FROM 
                        test_agl.skills as s 
                    ORDER BY 
                        s.id 
                    ASC';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Skill
        public function read_single()
        {
            // Create query
            $query = 'SELECT s.id, 
                        s.Description as description 
                    FROM 
                    test_agl.skills as s 
                    WHERE 
                        s.id = ?
                    ';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->description = $row['description'];
            
            
        }


        // Create Skill
        public function create()
        {
            // Create query
            $query = 'INSERT INTO test_agl.skills
                    SET
                    Description = :description';


            // Prepare Statement
            $stmt = $this->conn->prepare($query);


            // Clean data
            $this->description = htmlspecialchars(strip_tags($this->description));
            


            // Bind data
            $stmt->bindParam(':description', $this->description);


            // Execute query
            if($stmt->execute()){
                return true;
            } else {

                // Print error if something goes wrong
                printf("Error: %s. \n", $stmt->error);
                return false;

            }
        }

        // Update Skill
        public function update()
        {
            // Create query
            $query = 'UPDATE test_agl.skills 
                    SET
                    Description = :description
                    WHERE 
                        id = :id';


            // Prepare Statement
            $stmt = $this->conn->prepare($query);


            // Clean data
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->id = htmlspecialchars(strip_tags($this->id));


            // Bind data
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':id', $this->id);


            // Execute query
            if($stmt->execute()){
                return true;
            } else {

                // Print error if something goes wrong
                printf("Error: %s. \n", $stmt->error);
                return false;

            }
        }

        // Delete Skill
        public function delete() {
            // Create query
            $query = 'DELETE FROM test_agl.skills
                    WHERE 
                        id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
    }

    }





?>
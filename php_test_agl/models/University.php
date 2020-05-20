<?php

    class University {

        //DB Stuff
        private $conn;
        private $table = 'universities';

        //University Properties
        public $id;
        public $name;
        public $city_id;
        public $city_name;
        public $email;
        public $telephone_number;
        public $password;
        public $website;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }


        // Get all Universities
        public function read()
        {
            // Create query
            $query = 'SELECT uni.id, 
                        uni.Name as name, 
                        uni.CityId as city_id, 
                        uni.Email as email, 
                        uni.TelephoneNumber as telephone_number, 
                        uni.Website as website, 
                        uni.CityId as city_id, 
                        cit.name_3 as city_name, 
                        uni.Password as password 
                    FROM 
                        test_agl.universities as uni 
                    LEFT JOIN 
                        test_agl.lbn_adm3 as cit 
                    ON 
                        uni.CityId = cit.OGR_FID 
                    ORDER BY 
                        uni.id 
                    ASC';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single University
        public function read_single()
        {
            // Create query
            $query = 'SELECT uni.id, 
                        uni.Name as name, 
                        uni.CityId as city_id, 
                        uni.Email as email, 
                        uni.TelephoneNumber as telephone_number, 
                        uni.Website as website, 
                        uni.CityId as city_id, 
                        cit.name_3 as city_name, 
                        uni.Password as password
                    FROM 
                        test_agl.universities as uni 
                    LEFT JOIN 
                        test_agl.lbn_adm3 as cit 
                    ON 
                        uni.CityId = cit.OGR_FID
                    WHERE 
                        uni.id = ?
                    ';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->name = $row['name'];
            $this->city_id = $row['city_id'];
            $this->city_name = $row['city_name'];
            $this->email = $row['email'];
            $this->telephone_number = $row['telephone_number'];
            $this->password = $row['password'];
            $this->website = $row['website'];
            
        }


        // Create University
        public function create()
        {
            // Create query
            $query = 'INSERT INTO test_agl.universities
                    SET
                    Name = :uni_name, 
                    CityId = :city_id, 
                    Email = :email, 
                    TelephoneNumber = :telephone_number, 
                    Password = :password, 
                    Website = :website';


            // Prepare Statement
            $stmt = $this->conn->prepare($query);


            // Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->city_id = htmlspecialchars(strip_tags($this->city_id));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->telephone_number = htmlspecialchars(strip_tags($this->telephone_number));
            $this->website = htmlspecialchars(strip_tags($this->website));
            $this->password = htmlspecialchars(strip_tags($this->password));


            // Bind data
            $stmt->bindParam(':uni_name', $this->name);
            $stmt->bindParam(':city_id', $this->city_id);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':telephone_number', $this->telephone_number);
            $stmt->bindParam(':website', $this->website);
            $stmt->bindParam(':password', $this->password);


            // Execute query
            if($stmt->execute()){
                return true;
            } else {

                // Print error if something goes wrong
                printf("Error: %s. \n", $stmt->error);
                return false;

            }
        }

        // Update University
        public function update()
        {
            // Create query
            $query = 'UPDATE test_agl.universities  
                    SET
                        Name = :uni_name, 
                        CityId = :city_id, 
                        Email = :email, 
                        TelephoneNumber = :telephone_number, 
                        Password = :password, 
                        Website = :website
                    WHERE 
                        id = :id';


            // Prepare Statement
            $stmt = $this->conn->prepare($query);


            // Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->city_id = htmlspecialchars(strip_tags($this->city_id));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->telephone_number = htmlspecialchars(strip_tags($this->telephone_number));
            $this->website = htmlspecialchars(strip_tags($this->website));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->id = htmlspecialchars(strip_tags($this->id));


            // Bind data
            $stmt->bindParam(':uni_name', $this->name);
            $stmt->bindParam(':city_id', $this->city_id);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':telephone_number', $this->telephone_number);
            $stmt->bindParam(':website', $this->website);
            $stmt->bindParam(':password', $this->password);
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

        // Delete University
        public function delete() {
            // Create query
            $query = 'DELETE FROM test_agl.universities
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
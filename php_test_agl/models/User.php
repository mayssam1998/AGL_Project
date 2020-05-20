<?php

    class User {

        //DB Stuff
        private $conn;
        private $table = 'users';

        //User Properties
        public $id;
        public $first_name;
        public $last_name;
        public $email;
        public $university_id;
        public $university_name;
        public $city_id;
        public $city_name;
        public $date_of_birth;
        public $password;
        public $skills;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }


        // Get all Users
        public function read()
        {
            // Create query
            $query = 'SELECT u.id, 
                        u.FirstName as first_name, 
                        u.LastName as last_name, 
                        u.Email as email, 
                        u.UniversityId as university_id, 
                        uni.Name as university_name, 
                        u.CityId as city_id, 
                        cit.name_3 as city_name, 
                        u.DateOfBirth as date_of_birth, 
                        u.Password as password
                    FROM 
                        test_agl.users as u 
                    LEFT JOIN 
                        test_agl.universities as uni 
                    ON 
                        u.UniversityId=uni.id 
                    LEFT JOIN 
                        test_agl.lbn_adm3 as cit 
                    ON 
                        u.CityId = cit.OGR_FID 
                    ORDER BY 
                        u.id 
                    ASC';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single User
        public function read_single()
        {
            // Create query
            $query = 'SELECT u.id, 
                        u.FirstName as first_name, 
                        u.LastName as last_name, 
                        u.Email as email, 
                        u.UniversityId as university_id, 
                        uni.Name as university_name, 
                        u.CityId as city_id, 
                        cit.name_3 as city_name, 
                        u.DateOfBirth as date_of_birth, 
                        u.Password as password
                    FROM 
                        test_agl.users as u 
                    LEFT JOIN 
                        test_agl.universities as uni 
                    ON 
                        u.UniversityId=uni.id 
                    LEFT JOIN 
                        test_agl.lbn_adm3 as cit 
                    ON 
                        u.CityId = cit.OGR_FID 
                    WHERE 
                        u.id = ?
                    ';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->email = $row['email'];
            $this->university_id = $row['university_id'];
            $this->university_name = $row['university_name'];
            $this->city_id = $row['city_id'];
            $this->city_name = $row['city_name'];
            $this->date_of_birth = $row['date_of_birth'];
            $this->password = $row['password'];
            $this->skills = $this->getUserSkills($this->id);
            
        }


        // Create User
        public function create()
        {
            // Create query
            $query = 'INSERT INTO test_agl.users
                    SET
                    FirstName = :first_name, 
                    LastName = :last_name, 
                    Email = :email, 
                    UniversityId = :university_id, 
                    CityId = :city_id, 
                    DateOfBirth = :date_of_birth,
                    Password = :password';


            // Prepare Statement
            $stmt = $this->conn->prepare($query);


            // Clean data
            $this->first_name = htmlspecialchars(strip_tags($this->first_name));
            $this->last_name = htmlspecialchars(strip_tags($this->last_name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->university_id = htmlspecialchars(strip_tags($this->university_id));
            $this->city_id = htmlspecialchars(strip_tags($this->city_id));
            $this->date_of_birth = htmlspecialchars(strip_tags($this->date_of_birth));
            $this->password = htmlspecialchars(strip_tags($this->password));


            // Bind data
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':university_id', $this->university_id);
            $stmt->bindParam(':city_id', $this->city_id);
            $stmt->bindParam(':date_of_birth', $this->date_of_birth);
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

        // Update User
        public function update()
        {
            // Create query
            $query = 'UPDATE test_agl.users 
                    SET
                        FirstName = :first_name, 
                        LastName = :last_name, 
                        Email = :email, 
                        UniversityId = :university_id, 
                        CityId = :city_id, 
                        DateOfBirth = :date_of_birth,
                        Password = :password
                    WHERE 
                        id = :id';


            // Prepare Statement
            $stmt = $this->conn->prepare($query);


            // Clean data
            $this->first_name = htmlspecialchars(strip_tags($this->first_name));
            $this->last_name = htmlspecialchars(strip_tags($this->last_name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->university_id = htmlspecialchars(strip_tags($this->university_id));
            $this->city_id = htmlspecialchars(strip_tags($this->city_id));
            $this->date_of_birth = htmlspecialchars(strip_tags($this->date_of_birth));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->id = htmlspecialchars(strip_tags($this->id));


            // Bind data
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':university_id', $this->university_id);
            $stmt->bindParam(':city_id', $this->city_id);
            $stmt->bindParam(':date_of_birth', $this->date_of_birth);
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

        // Delete User
        public function delete() {
            // Create query
            $query = 'DELETE FROM test_agl.users
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

        // Get User Skills
        public function getUserSkills($user_id) {
            // Create query
            $query = 'SELECT s.Id as id, 
                        s.Description as description, 
                        us.Proficiency as proficiency 
                    FROM 
                        test_agl.skills as s 
                    LEFT JOIN 
                        test_agl.userskill as us 
                    ON 
                        s.Id=us.SkillId 
                    WHERE 
                        UserId =  :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':id', $user_id);

            // Execute query
            $stmt->execute();

            // Get row count
            $num = $stmt->rowCount();

            // Check if any users
            if($num > 0){
                $skills_arr = array();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);

                    $skill_item = array(

                        'id'=> $id,
                        'description'=> $description,
                        'proficiency'=> $proficiency

                    );

                    // Push to "data"
                    array_push($skills_arr,$skill_item);
                }

                // Turn to JSON & output
                return $skills_arr;
            } else {
                // NO Skills
                return array();
            }

        }

        // Get User From Email
        public function getUserFromEmail($email) {
            // Create query
            $query = 'SELECT u.id, 
                        u.Email as email,
                        u.Password as password
                    FROM 
                        test_agl.users as u 
                    WHERE 
                        u.Email = ?
                    ';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $email);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Insert User Skill
        public function insertUserSkill($skill_id,$proficiency) {
            // Create query
            $query = 'INSERT INTO 
                        test_agl.userskill (UserId, SkillId, Proficiency) 
                    VALUES 
                        (:user_id ,:skill_id, :proficiency)';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':user_id', $this->id);
            $stmt->bindParam(':skill_id', $skill_id);
            $stmt->bindParam(':proficiency', $proficiency);

            // Execute query
            if($stmt->execute()){
                return true;
            } else {

                // Print error if something goes wrong
                printf("Error: %s. \n", $stmt->error);
                return false;

            }
        }

        // Delete User Skill
        public function deleteUserSkill($skill_id) {
            // Create query
            $query = 'DELETE FROM test_agl.userskill 
                    WHERE 
                        UserId = :user_id 
                    AND 
                        SkillId = :skill_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':user_id', $this->id);
            $stmt->bindParam(':skill_id', $skill_id);

            // Execute query
            if($stmt->execute()){
                return true;
            } else {

                // Print error if something goes wrong
                printf("Error: %s. \n", $stmt->error);
                return false;

            }
        }

    

    }





?>
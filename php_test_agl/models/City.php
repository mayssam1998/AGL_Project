<?php

    class City {

        //DB Stuff
        private $conn;
        private $table = 'lbn_adm3';

        //City Properties
        public $id;
        public $name;
        public $district_id;
        public $district_name;
        public $gouvernat_id;
        public $gouvernat_name;
        public $country_id;
        public $country_name;
        public $date_of_birth;
        public $centroid;
        public $polygon;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }


        // Get all Cities
        public function read()
        {
            // Create query
            $query = 'SELECT OGR_FID as id, 
                        ST_AsGeoJSON(ST_Centroid(SHAPE)) as centroid, 
                        ST_AsGeoJSON(SHAPE) as polygon,
                        id_0 as country_id, 
                        name_0 as country_name, 
                        id_1 as gouvernat_id, 
                        name_1 as gouvernat_name, 
                        id_2 as district_id, 
                        name_2 as district_name, 
                        name_3 as name 
                    FROM test_agl.lbn_adm3
                    ORDER BY 
                        OGR_FID 
                    ASC';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Cities
        public function read_single()
        {
            // Create query
            $query = 'SELECT OGR_FID as id, 
                        ST_AsGeoJSON(ST_Centroid(SHAPE)) as centroid, 
                        ST_AsGeoJSON(SHAPE) as polygon,
                        id_0 as country_id, 
                        name_0 as country_name, 
                        id_1 as gouvernat_id, 
                        name_1 as gouvernat_name, 
                        id_2 as district_id, 
                        name_2 as district_name, 
                        name_3 as name 
                    FROM test_agl.lbn_adm3
                    WHERE 
                        OGR_FID = ?
                    ';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->country_id = $row['country_id'];
            $this->country_name = $row['country_name'];
            $this->gouvernat_id = $row['gouvernat_id'];
            $this->gouvernat_name = $row['gouvernat_name'];
            $this->district_id = $row['district_id'];
            $this->district_name = $row['district_name'];
            $this->name = $row['name'];
            $this->centroid =  json_decode($row['centroid'],true)['coordinates'];
            $this->polygon = json_decode($row['polygon'],true)['coordinates'];
            
        }

        // Get all Cities
        public function readTopK($skill_id,$k)
        {
            // Create query
            $query = 'SELECT lbn_adm3.OGR_FID as id, 
                        lbn_adm3.name_3 as name,
                        ST_AsGeoJSON(ST_Centroid(SHAPE)) as centroid, 
                        ST_AsGeoJSON(SHAPE) as polygon,
                        id_0 as country_id, 
                        name_0 as country_name, 
                        id_1 as gouvernat_id, 
                        name_1 as gouvernat_name, 
                        id_2 as district_id, 
                        name_2 as district_name, 
                        COUNT(*)  as total
                    FROM 
                    (SELECT 
                        userskill.UserId 
                    FROM 
                        test_agl.userskill 
                    WHERE 
                        userskill.SkillId = :skill_id) as users2 
                    LEFT JOIN 
                        test_agl.users 
                    ON 
                        users2.UserId = users.id 
                    LEFT JOIN 
                        test_agl.lbn_adm3 
                    ON 
                        users.CityId = lbn_adm3.OGR_FID 
                    GROUP BY 
                        lbn_adm3.OGR_FID 
                    ORDER BY 
                        total 
                    DESC 
                    LIMIT :k';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

             // Clean data
             $skill_id = htmlspecialchars(strip_tags($skill_id));
             $k = htmlspecialchars(strip_tags($k));

             // Bind data
            $stmt->bindParam(':skill_id', $skill_id);
            $stmt->bindValue(':k', (int) $k, PDO::PARAM_INT);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

    }





?>
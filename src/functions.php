<?php

/* Add your functions here */
include "config/config.php";

function dbConnect(){
    /* defined in config/config.php */
    /*** connection credentials *******/
    $servername = SERVER;
    $username = USERNAME;
    $password = PASSWORD;
    $database = DATABASE;
    $dbport = PORT;
    /****** connect to database **************/

    try {
        $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4;port=$dbport", $username, $password);
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
    return $db;
}

function initialSql($n, $r, $g) {
            $s = "SELECT l.id, n.neighborhood, r.type, l.accommodates, l.pictureUrl, l.name, l.rating, l.price FROM listings l
            LEFT JOIN neighborhoods n ON l.neighborhoodId = n.id
            LEFT JOIN roomTypes r ON l.roomTypeId = r.id ";
            if ($n == "Any") {
                $s .= "WHERE ";
            } else {
                $s .= "WHERE l.neighborhoodId = $n AND ";
            }
            if ($r == "Any") {
                $s .= "l.roomTypeId >= 1";
            } else {
                $s .= " l.roomTypeId = $r";
            }
            $s .= " AND l.accommodates = $g LIMIT 20;";
       
            return $s;
        }

        function countSql($n, $r, $g) {
            $s = "SELECT COUNT(*) AS total_count FROM (
                SELECT 1 FROM listings WHERE ";
            if ($n == "Any") {
                $s .= "1 ";
            } else {
                $s .= "neighborhoodId = $n ";
            }
            if ($r == "Any") {
                $s .= "AND roomTypeId >= 1 ";
            } else {
                $s .= "AND roomTypeId = $r ";
            }
            $s .= "AND accommodates = $g LIMIT 20) AS subquery;";
            
            return $s;
        }

        function neighborhoodTrans($n) {
            if ($n == "Any") {
                return $n;
            } else {
                $s = "SELECT neighborhood FROM neighborhoods WHERE id = $n";
                $conn = dbConnect();
                foreach ($conn->query($s) as $row) {
                    return $row['neighborhood'];
                }
            }
    
        }

        function roomTrans($r) {
            if ($r == "Any") {
                return $r;
            } else {
                $s = "SELECT type FROM roomTypes WHERE id = $r";
                $conn = dbConnect();
                foreach ($conn->query($s) as $row) {
                    return $row['type'];
                }
            }
    
        }

?>
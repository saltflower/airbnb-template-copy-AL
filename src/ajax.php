<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../config/config.php";

function dbConnect()
{
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
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $db;
}

$id = $_GET['id'];
$q = $_GET['action'];
$result = [];
// Connect to the database
$conn = dbConnect();

if ($q == "getData") {
    $s = "SELECT l.name, l.pictureUrl, n.neighborhood, l.price, l.accommodates, l.rating, h.hostName
FROM listings l LEFT JOIN neighborhoods n ON l.neighborhoodId = n.id
LEFT JOIN hosts h ON l.hostId = h.id
WHERE l.id = $id;";
$result = $conn->query($s)->fetch(PDO::FETCH_ASSOC);
}
if ($q == "getAmenities") {
    $s = "SELECT a.amenity FROM listingAmenities la JOIN amenities a ON la.amenityID = a.id WHERE la.listingID = $id;";
    foreach ($conn->query($s) as $row) {
        $result[] = $row['amenity'];
    }
}




header('Content-Type: application/json');
if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(['error' => 'No data found for the given ID.']);
}

<?php


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
    //for retrieving all data about the listing besides amenities
    $s = "SELECT l.name, l.pictureUrl, n.neighborhood, l.price, l.accommodates, l.rating, h.hostName
FROM listings l LEFT JOIN neighborhoods n ON l.neighborhoodId = n.id
LEFT JOIN hosts h ON l.hostId = h.id
WHERE l.id = $id;";
    $sth = $conn->prepare($s);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
}
if ($q == "getAmenities") {
    //for retrieving the list of amenities
    $s = "SELECT a.amenity FROM listingAmenities la JOIN amenities a ON la.amenityID = a.id WHERE la.listingID = $id;";
    $sth = $conn->prepare($s);
    $sth->execute();
    foreach ($sth->fetchAll() as $row) {
        $result[] = $row['amenity'];
    }
}



//send
header('Content-Type: application/json');
if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(['error' => 'No data found for the given ID.']);
}

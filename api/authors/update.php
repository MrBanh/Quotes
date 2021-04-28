<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Import files needed for database connection
require_once('../../config/Database.php');
require_once('../../models/Author.php');

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate new Author object
$author = new Author($db);

// Get raw json data from request
$data = json_decode(file_get_contents('php://input'));

// Make sure raw json data includes both 'id' and 'author'
if(isset($data->id) && isset($data->author)) {
    // Set the object property - MUST contain id and author
    $author->set_id($data->id);
    $author->set_name($data->author);

    // Update Author
    $status = $author->update();

    if($status === true) {
        echo json_encode(array('message' => 'Author Updated'));
        http_response_code(200);        // 200 OK

    } elseif ($status === false) {
        echo json_encode(array('message' => 'Author Not Updated'));
        http_response_code(404);        // 404 Not Found

    } else {

        switch($status->errorInfo[1]) {
            case 1062:
                echo json_encode(array('message' => 'Author Not Updated. Duplicate entry.'));
                http_response_code(409);        // 409 Conflict
                break;
        }
    }

} else {
    echo json_encode(array('message' => 'Author Not Updated. MUST contain \'id\' and \'author\'.'));
    http_response_code(400);        // 400 Bad Request
}

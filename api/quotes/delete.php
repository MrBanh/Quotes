<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Import files needed for database connection
require_once('../../config/Database.php');
require_once('../../models/Quote.php');

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate new Quote object
$quote = new Quote($db);

// Get raw json data from request
$data = json_decode(file_get_contents('php://input'));

// Make sure raw json data includes 'id'
if(isset($data->id)) {
    // Set the object property - MUST contain the id
    $quote->set_id($data->id);

    // Delete Quote
    if($quote->delete()) {
        echo json_encode(array('message' => 'Quote Deleted'));
        http_response_code(200);        // 200 OK
    } else {
        echo json_encode(array('message' => 'Quote Not Deleted. Quote not found.'));
        http_response_code(404);        // 404 Not Found
    }

} else {
    echo json_encode(array('message' => 'Quote Not Deleted. MUST contain \'id\'.'));
    http_response_code(400);        // 400 Bad Request
}
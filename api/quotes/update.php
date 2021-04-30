<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: PUT');
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

// Make sure raw json data includes: id, quote, authorId, and categoryId
if(isset($data->id, $data->quote, $data->authorId, $data->categoryId)) {
    // Set the object property - MUST contain id and quote
    $quote->set_id($data->id);
    $quote->set_quote($data->quote);
    $quote->set_authorId($data->authorId);
    $quote->set_categoryId($data->categoryId);

    // Update Quote
    $status = $quote->update();

    if($status === true) {
        echo json_encode(array('message' => 'Quote Updated'));
        http_response_code(200);        // 200 OK

    } elseif ($status === false) {
        echo json_encode(array('message' => 'Quote Not Updated. Quote not found.'));
        http_response_code(404);        // 404 Not Found

    } else {
        // SQL Integrity Constraint Violations
        switch($status->errorInfo[1]) {
            case 1452:
                echo json_encode(array('message' => 'Quote Not Updated. \'authorId\' or \'categoryId\' (or both) you provided does not exist.'));
                http_response_code(404);        // 404 Not Found
                break;
        }
    }

} else {
    echo json_encode(array('message' => 'Quote Not Updated. MUST contain \'id\', \'quote\', \'authorId\', and \'categoryId\'.'));
    http_response_code(400);        // 400 Bad Request
}
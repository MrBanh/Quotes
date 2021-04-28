<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: POST');
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

// Make sure raw json data includes correct keys: quote, authorId, categoryId
if(isset($data->quote, $data->authorId, $data->categoryId)) {
    // Set the object property - MUST contain the quote
    $quote->set_quote($data->quote);
    $quote->set_authorId($data->authorId);
    $quote->set_categoryId($data->categoryId);

    // Create Quote
    if($quote->create()) {
        echo json_encode(array('message' => 'Quote Created'));
        http_response_code(201);        // 201 Created
    } else {
        echo json_encode(array('message' => 'Quote Not Created. Duplicate entry.'));
        http_response_code(409);        // 409 Conflict
    }

} else {
    echo json_encode(array('message' => 'Quote Not Created. MUST contain \'quote\', \'authorId\', and \'categoryId\'.'));
    http_response_code(400);        // 400 Bad Request
}
<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Import files needed for database connection
require_once('../../config/Database.php');
require_once('../../models/Quote.php');

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate new Quote object
$quote = new Quote($db);

// Get id from query params
$quote_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if($quote_id) {
    $quote->set_id($quote_id);
    $result = $quote->read_single();

    // Check if quote found
    if ($result) {
        echo json_encode($result);
        http_response_code(200);        // 200  OK
    } else {
        echo json_encode(array('message' => 'No Quote Found'));
        http_response_code(404);        // 404  Not Found
    }

} else {
    // Not valid query param for id
    echo json_encode(array('message' => 'No Quote Found. MUST contain valid \'id\' param.'));
    http_response_code(400);        // 400  Bad Request
}
<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Import files needed for database connection
require_once('../../config/Database.php');
require_once('../../models/Author.php');

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate new Author object
$author = new Author($db);

// Get id from query params
$author_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if(isset($author_id)) {
    $author->set_id($author_id);
    $result = $author->read_single();

    // Check if author found
    if ($result) {
        echo json_encode($result);
        http_response_code(200);        // 200  OK
    } else {
        echo json_encode(array('message' => 'No Author Found'));
        http_response_code(404);        // 404  Not Found
    }

} else {
    // Not valid query param for id
    echo json_encode(array('message' => 'Not a valid author id'));
    http_response_code(400);        // 400  Bad Request
}
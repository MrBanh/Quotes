<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Import files needed for database connection
require_once('../../config/Database.php');
require_once('../../models/Category.php');

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate new Category object
$category = new Category($db);

// Get id from query params
$category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if(isset($category_id)) {
    $category->set_id($category_id);
    $result = $category->read_single();

    // Check if category found
    if ($result) {
        echo json_encode($result);
        http_response_code(200);        // 200  OK
    } else {
        echo json_encode(array('message' => 'No Category Found'));
        http_response_code(404);        // 404  Not Found
    }

} else {
    // Not valid query param for id
    echo json_encode(array('message' => 'No Category Found. MUST contain \'id\' param.'));
    http_response_code(400);        // 400  Bad Request
}
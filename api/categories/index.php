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

// Read query
$results = $category->read();

// Check if any results found
if(count($results) > 0) {
    echo json_encode($results);
    http_response_code(200);        // 200 OK
} else {
    echo json_encode(array('message' => 'No Categories Found'));
    http_response_code(404);        // 404 Not Found
}
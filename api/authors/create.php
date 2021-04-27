<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: POST');
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

// Set the object property - MUST contain the author
$author->set_name($data->author);

// Create Author
if($author->create()) {
    echo json_encode(array('message' => 'Author Created'));
    http_response_code(201);        // 201 Created
} else {
    echo json_encode(array('message' => 'Author Not Created'));
    http_response_code(409);        // 409 Conflict
}
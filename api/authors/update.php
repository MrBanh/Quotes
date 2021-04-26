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

// Set the object property - MUST contain id and author
$author->set_id($data->id);
$author->set_name($data->author);

// Create Author
if($author->update()) {
    echo json_encode(array('message' => 'Author Updated'));
} else {
    echo json_encode(array('message' => 'Author Not Updated'));
}
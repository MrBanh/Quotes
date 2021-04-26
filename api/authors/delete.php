<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: DELETE');
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

// Set the object property - MUST contain the id
$author->set_id($data->id);

// Create Author
if($author->delete()) {
    echo json_encode(array('message' => 'Author Deleted'));
} else {
    echo json_encode(array('message' => 'Author Not Deleted'));
}
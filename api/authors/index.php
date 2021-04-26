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

// Read query
$results = $author->read();

// Check if any results found
if(count($results) > 0) {
    echo json_encode($results);
} else {
    echo json_encode(array('message' => 'No Authors Found'));
}
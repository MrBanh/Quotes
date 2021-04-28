<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Import files needed for database connection
require_once('../../config/Database.php');
require_once('../../models/Category.php');

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate new Category object
$category = new Category($db);

// Get raw json data from request
$data = json_decode(file_get_contents('php://input'));

// Make sure raw json data includes correct key ('category')
if(isset($data->category)) {
    // Set the object property - MUST contain the category
    $category->set_name($data->category);

    // Create Category
    if($category->create()) {
        echo json_encode(array('message' => 'Category Created'));
        http_response_code(201);        // 201 Created
    } else {
        echo json_encode(array('message' => 'Category Not Created. Duplicate entry.'));
        http_response_code(409);        // 409 Conflict
    }

} else {
    echo json_encode(array('message' => 'Category Not Created. MUST contain \'category\'.'));
    http_response_code(400);        // 400 Bad Request
}

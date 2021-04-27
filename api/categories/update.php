<?php
// Headers for response
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: PUT');
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

// Make sure raw json data includes both 'id' and 'category'
if(isset($data->id) && isset($data->category)) {
    // Set the object property - MUST contain id and category
    $category->set_id($data->id);
    $category->set_name($data->category);

    // Update Category
    $status = $category->update();

    if($status === true) {
        echo json_encode(array('message' => 'Category Updated'));
        http_response_code(200);        // 200 OK

    } elseif ($status === false) {
        echo json_encode(array('message' => 'Category Not Updated'));
        http_response_code(404);        // 404 Not Found

    } else {
        echo json_encode(array('message' => 'Category Not Updated'));

        switch($status->errorInfo[1]) {
            case 1062:
                http_response_code(409);        // 409 Conflict
                break;
        }
    }

} else {
    echo json_encode(array('message' => 'Category Not Updated. MUST contain \'id\' and \'category\'.'));
    http_response_code(400);        // 400 Bad Request
}

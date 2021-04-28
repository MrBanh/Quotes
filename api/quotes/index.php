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

/**
 * Query Params
 */

// @param authorId=5 - response: quotes with an authorId = 5
$authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);

// @param categoryId=8 - response: quotes with a categoryId = 8
$categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);

// @param limit=3 - response: quotes limited to 3 quotes, adheres to other parameters
$limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);

// @param random=true - response: random quote that adheres to other parameters
$random = filter_input(INPUT_GET, 'random', FILTER_VALIDATE_BOOLEAN);

// Set Quote properties for filtering SQL query - authorId, categoryId, limit
if ($authorId) $quote->set_authorId($authorId);
if ($categoryId) $quote->set_categoryId($categoryId);
if ($limit && $limit > 0) $quote->set_limit($limit);

// Read query
$results = $quote->read();

// Check if any results found
if(count($results) > 0) {

    if ($random) {
        $randomQuote = $results[mt_rand(0, count($results) - 1)];
        echo json_encode($randomQuote);
    } else {
        echo json_encode($results);
    }

    http_response_code(200);        // 200 OK
} else {
    echo json_encode(array('message' => 'No Quotes Found'));
    http_response_code(404);        // 404 Not Found
}
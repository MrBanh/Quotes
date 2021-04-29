<?php
require_once('config/Database.php');
require_once('models/Author.php');
require_once('models/Category.php');
require_once('models/Quote.php');

// Instantiate objects
$database = new Database();
$db = $database->connect();
$author = new Author($db);
$category = new Category($db);
$quote = new Quote($db);

// Obtain query params (if any), and set properties in quote object
$authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
$categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
if ($authorId) $quote->set_authorId($authorId);
if ($categoryId) $quote->set_categoryId($categoryId);

// Obtain list of all authors
$authors = $author->read();

// Obtain list of all categories
$categories = $category->read();

// Obtain list of quotes, which includes the authorId and/or categoryId filter (if any)
$quotes = $quote->read();

// Public web page at root directory
include('views/quotes_list.php');

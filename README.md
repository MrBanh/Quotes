# INF653 Back End Web Development - Final Project Requirements

- [ ] 1. You will build a REST API for quotations - both famous quotes and user submissions

- [ ] 2. ALL quotes are required to have ALL 3 of the following:
  - Quote (the quotation itself)
  - Author
  - Category

- [ ] 3. Create a database named “quotesdb” with 3 tables and these specific column names:
  - quotes (id, quote, authorId, categoryId) - the last two are foreign keys
  - authors (id, author)
  - categories (id, category)

- [ ] 4. Response requirements:
  - All requests should provide a JSON data response.
  - All requests for quotes should return the id, quote, author, and category fields.
  - If the parameter “authorId” is received, the response should only include quotes attributed to the specified author.
  - If the parameter “categoryId” is received, the response should only include quotes within the specified category.
  - If “authorId” and “categoryId” parameters are passed to the endpoint, the response should only include quotes from the specified author that are within the specified category.
  - If the parameter “limit” is passed with a request, the response should limit the quotes in the response to no more than the number specified.

- [ ] 5. Your REST API will provide responses to the following GET requests:
  - /api/quotes/ requests return (id, quote, author, category)
  - /api/authors/ requests return (id, author)
  - /api/categories/ requests return (id, category)

  | Request:                             | Response (fields):                                    |
  | ------------------------------------ | ----------------------------------------------------- |
  | /api/quotes/                         | All quotes are returned (id, quote, author, category) |
  | /api/quotes/read_single.php?id=4     | The specific quote                                    |
  | /api/quotes/?authorId=10             | All quotes from authorId=10                           |
  | /api/quotes/?categoryId=8            | All quotes in categoryId=8                            |
  | /api/quotes/?authorId=3&categoryId=4 | All quotes from authorId=3 that are in categoryId=4   |
  | /api/quotes/?limit=3                 | All quotes but limited to 3 quotes                    |
  | /api/authors/                        | All authors with their id                             |
  | /api/authors/read_single.php?id=5    | The specific author with their id                     |
  | /api/categories/                     | All categories with their ids (id, category)          |
  | /api/categories/read_single.php?id=7 | The specific category with its id                     |

  \
    **NOTE**: In the above examples, the parameter numbers are examples. You could change the limit=5 or
    the authorId=2, etc. and the requests should still have the appropriate response.

- [ ] 6. Your REST API will provide responses to the following POST requests:

  | Request:                             | Response (fields):                                          |
  | ------------------------------------ | ----------------------------------------------------------- |
  | /api/quotes/create.php               | { message: 'Quote Created' }                                |
  | /api/authors/create.php              | { message: 'Author Created' }                               |
  | /api/categories/create.php           | { message: 'Category Created' }                             |

  \
    **Note**: To create a quote, the POST submission MUST contain the quote, authorId, and categoryId.\
    **Note**: To create an author, the POST submission MUST contain the author.\
    **Note**: To create a category, the POST submission MUST contain the category.

- [ ] 7. Your REST API will provide responses to the following PUT requests:

  | Request:                             | Response (fields):                                             |
  | ------------------------------------ | -------------------------------------------------------------- |
  | /api/quotes/update.php               | { message: 'Quote Updated' }                                   |
  | /api/authors/update.php              | { message: 'Author Updated' }                                  |
  | /api/categories/update.php           | { message: 'Category Updated' }                                |

  \
    **Note**: To update a quote, the PUT submission MUST contain the id, quote, authorId, and categoryId.\
    **Note**: To create an author, the PUT submission MUST contain the id and author.\
    **Note**: To create a category, the PUT submission MUST contain the id and category.

- [ ] 8. Your REST API will provide responses to the following DELETE requests:

  | Request:                             | Response (fields):                                             |
  | ------------------------------------ | -------------------------------------------------------------- |
  | /api/quotes/delete.php               | { message: 'Quote Deleted' }                                   |
  | /api/authors/delete.php              | { message: 'Author Deleted' }                                  |
  | /api/categories/delete.php           | { message: 'Category Deleted' }                                |

  \
    **Note**: All delete requests require the id to be submitted.

- [ ] 9. A public web page available in your root directory (index.php) which displays all quotes and provides select (dropdown) menus allowing a user to filter by author, category, or both. Responsive design for viewing in all viewports from mobile to desktop.

- [ ] 10. Your project should have a GitHub repository with a pipeline connected to Heroku. The project should utilize JawsDB on Heroku for the database. As with the Zippys project, you may develop the database locally on MySQL first.

- [ ] 11. You will need to populate your own quotes database. You may want to first create secure admin pages that allow you to add authors and categories and then create a page to add quotes as we did with Zippys. This is up to you as these additional pages are not required (although useful). You may choose to simply populate the database manually or with Postman to start out. A good site to find quotes by category (topic) is: https://www.brainyquote.com/ Minimum 5 categories. Minimum 5 authors. Minimum 25 quotes total for initial data.

- [ ] 12. Submit the following:
  - A link to your GitHub code repository (no code updates after the due date accepted on the final project)
  - A link to your deployed project on Heroku
  - A one page PDF document discussing what challenges you faced while building your project.

## Extra Credit

- [ ] Not Required but useful: Allow a “random=true” parameter to be sent via GET request so the response received does not always contain the same quotes. The response should contain random quotes that still adhere to the other specified parameters. For example, this will allow users of the API to retrieve a single random quote, a single random quote from Bill Gates, or a single random quote about life (category).

## Important Note:

- The endpoints that perform the “read all” action do not have a specific “page.php” at the end of their URLs. You may think of this as the “read.php” from the example tutorials. However, for a URL like “/api/quotes/” to return all quotes, you should name the “read.php” file “index.php” instead. You do not need to specify “index.php” at the end of the URL for it to load. It will do so by default. ...And this is not the index.php in your root directory as in requirement # 9 above.

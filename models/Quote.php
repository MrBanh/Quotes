<?php
    /**
     *  Creates a new Quote.
     *  @class
     */
    class Quote {
        // DB Connection
        private $conn;
        private $table = 'quotes';
        private $col_name = 'quote';

        // Properties for SQL Query clauses
        private $limit;     // Limits results from query

        // Class properties
        private $id, $quote;
        private $authorId, $authorName;
        private $categoryId, $categoryName;

        // Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // Setters/Getters for properties
        public function get_limit() {
            return $this->limit;
        }

        public function set_limit($limit) {
            $this->limit = htmlspecialchars(strip_tags($limit));
        }

        public function get_id() {
            return $this->id;
        }

        public function set_id($id) {
            $this->id = htmlspecialchars(strip_tags($id));
        }

        public function get_quote() {
            return $this->quote;
        }

        public function set_quote($quote) {
            $this->quote = htmlspecialchars(strip_tags($quote));
        }

        public function get_authorId() {
            return $this->authorId;
        }

        public function set_authorId($authorId) {
            $this->authorId = htmlspecialchars(strip_tags($authorId));
        }

        public function get_authorName() {
            return $this->authorName;
        }

        public function set_authorName($authorName) {
            $this->authorName = htmlspecialchars(strip_tags($authorName));
        }

        public function get_categoryId() {
            return $this->categoryId;
        }

        public function set_categoryId($categoryId) {
            $this->categoryId = htmlspecialchars(strip_tags($categoryId));
        }

        public function get_categoryName() {
            return $this->categoryName;
        }

        public function set_categoryName($categoryName) {
            $this->categoryName = htmlspecialchars(strip_tags($categoryName));
        }

        // Methods for DB CRUD Operations

        /**
         *  @return Array - An associative array of all the records in DB
         */
        public function read() {
            $query = 'SELECT q.id as id, q.quote as quote, a.author as author, c.category as category
                        FROM ' . $this->table . ' q
                        LEFT JOIN
                            authors a ON q.authorId = a.id
                        LEFT JOIN
                            categories c ON q.categoryId = c.id';

            // WHERE clause if either authorId or categoryId is set
            $filters = array();
            if ($this->authorId) $filters[] = 'q.authorId = ' . $this->authorId;
            if ($this->categoryId) $filters[] = 'q.categoryId = ' . $this->categoryId;
            if (count($filters) > 0) {
                $query .= ' WHERE ';
                $query .= implode(' AND ', $filters);
            }

            // ORDER BY clause
            $query .= ' ORDER BY q.id';

            // LIMIT clause
            if ($this->limit > 0) $query .= ' LIMIT ' . $this->limit;

            $statement = $this->conn->prepare($query);

            // Execute query
            $statement->execute();

            // Fetch all records
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Close connection
            $statement->closeCursor();

            // Return results
            return $rows;
        }

        /**
         *  Obtains specific record based on id and set the object's properties
         *  @return Array - An associative array for the record found in DB
         */
        public function read_single() {
            $query = 'SELECT q.id as id, q.quote as quote, a.author as author, c.category as category
                        FROM ' . $this->table . ' q
                        LEFT JOIN
                            authors a ON q.authorId = a.id
                        LEFT JOIN
                            categories c ON q.categoryId = c.id
                        WHERE
                            q.id = :id LIMIT 1';

            $statement = $this->conn->prepare($query);

            // Bind the data
            $statement->bindParam(':id', $this->id);

            // Execute query
            $statement->execute();

            // Fetch data from query
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Close connection
            $statement->closeCursor();

            return $row;
        }

        /**
         *  Add a new record to the table in the database
         *  @return bool - True if new record added to database, false otherwise
         */
        public function create() {
            $query = 'INSERT INTO  '. $this->table . ' (quote, authorId, categoryId)' .
                        ' VALUES (:quote, :authorId, :categoryId)';

            try {
                $statement = $this->conn->prepare($query);

                // Bind data
                $statement->bindParam(':quote', $this->quote);
                $statement->bindParam(':authorId', $this->authorId);
                $statement->bindParam(':categoryId', $this->categoryId);

                // Execute query
                if($statement->execute() && ($statement->rowCount() > 0)) {
                    return true;
                } else {
                    return false;
                }

            } catch (PDOException $e) {
                return false;

            } finally {
                // Close connection
               $statement->closeCursor();
            }
        }

        /**
         *  Updates the record in the table in database
         *  @return bool|PDOException - True if query execution was successful and affected >1 row in DB.
         *                       Returns it query executed but no rows affected.
         *                       Returns error object if query results in an error thrown
         */
        public function update() {
            // If the record with specific id doesn't exist, no need to update
            if (!$this->read_single()) {
                return false;
            }

            $query = 'UPDATE ' . $this->table .
                        ' SET quote = :quote, authorId = :authorId, categoryId = :categoryId' .
                        ' WHERE id = :id';

            try {
                $statement = $this->conn->prepare($query);

                // Bind data
                $statement->bindParam(':quote', $this->quote);
                $statement->bindParam(':authorId', $this->authorId);
                $statement->bindParam(':categoryId', $this->categoryId);
                $statement->bindParam(':id', $this->id);

                // Execute query
                if($statement->execute()) {
                    return true;
                }

            } catch (PDOException $e) {
                return $e;

            } finally {
                // Close connection
                $statement->closeCursor();
            }
        }

        /**
         *  Deletes a record from database based on id
         *  @return bool - True if record was deleted, false otherwise
         */
        public function delete() {
            $query = 'DELETE FROM ' . $this->table .
                        ' WHERE id = :id';

            try {
                $statement = $this->conn->prepare($query);
                $statement->bindParam(':id', $this->id);

                // Execute query
                if($statement->execute() && ($statement->rowCount() > 0)) {
                    return true;
                } else {
                    return false;
                }

            } catch (PDOException $e) {
                return false;

            } finally {
                // Close connection
                $statement->closeCursor();
            }
        }
    }
?>
<?php
    /**
     *  Creates a new Author.
     *  @class
     */
    class Author {
        // DB Connection
        private $conn;
        private $table = 'authors';
        private $col_name = 'author';

        // Class properties
        private $id, $name;

        // Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // Setters/Getters for properties
        public function get_id() {
            return $this->id;
        }

        public function set_id($id) {
            $this->id = htmlspecialchars(strip_tags($id));
        }

        public function get_name() {
            return $this->name;
        }

        public function set_name($name) {
            $this->name = htmlspecialchars(strip_tags($name));
        }

        // Methods for DB CRUD Operations

        /**
         *  @return {Array} - An associative array of all the records in DB
         */
        public function read() {
            $query = 'SELECT id, ' . $this->col_name .
                        ' FROM ' . $this->table .
                        ' ORDER BY id';
            $statement = $this->conn->prepare($query);

            // Execute query
            $statement->execute();

            // Fetch all records
            $rows = $statement->fetchAll();

            // Close connection
            $statement->closeCursor();

            // Return results
            return $rows;
        }

        /**
         *  Obtains specific record based on id and set the object's properties
         */
        public function read_single() {
            $query = 'SELECT id, ' . $this->col_name .
                        ' FROM ' . $this->table .
                        ' WHERE id = :id LIMIT 1';
            $statement = $this->conn->prepare($query);

            // Bind the data
            $statement->bindParam(':id', $this->get_id());

            // Execute query
            $statement->execute();

            // Fetch data from query
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Close connection
            $statement->closeCursor();

            // Set properties if query found record in DB
            if ($row) {
                $this->set_id($row['id']);
                $this->set_name($row[$this->col_name]);
            }
        }

        /**
         *  Add a new record to the table in the database
         *  @return {bool} - True if new record added to database, false otherwise
         */
        public function create() {
            $query = 'INSERT INTO  '. $this->table . ' (' . $this->col_name . ')' .
                        ' VALUES (:name)';
            $success = false;

            $statement = $this->conn->prepare($query);

            // Bind data
            $statement->bindParam(':name', $this->get_name());

            // Execute query
            if($statement->execute()) {
                $success = true;
            } else {
                $success = false;

                // Display error if something goes wrong
                printf("Error: [%s].\n", $statement->error);
            }

            // Close connection
            $statement->closeCursor();

            // Return true if query executed fine, false otherwise
            return $success;
        }

        /**
         *  Updates the record in the table in database
         *  @return {bool} - True if query execution was successful, false otherwise
         */
        public function update() {
            $query = 'UPDATE ' . $this->table .
                        ' SET ' . $this->col_name . ' = :name' .
                        ' WHERE id = :id';
            $success = false;

            $statement = $this->conn->prepare($query);

            // Bind data
            $statement->bindParam(':name', $this->get_name());
            $statement->bindParam(':id', $this->get_id());

            // Execute query
            if($statement->execute()) {
                $success = true;
            } else {
                $success = false;

                // Display error if something goes wrong
                printf("Error: [%s].\n", $statement->error);
            }

            // Close connection
            $statement->closeCursor();

            // Return true if query executed fine, false otherwise
            return $success;
        }

        /**
         *  Deletes a record from database based on id
         *  @return {bool} - True if record was deleted, false otherwise
         */
        public function delete() {
            $query = 'DELETE FROM ' . $this->table .
                        ' WHERE id = :id';
            $success = false;

            $statement = $this->conn->prepare($query);
            $statement->bindParam(':id', $this->get_id());

            // Execute query
            if($statement->execute()) {
                $success = true;
            } else {
                $success = false;

                // Display error if something goes wrong
                printf("Error: [%s].\n", $statement->error);
            }

            // Close connection
            $statement->closeCursor();

            // Return true if query executed fine, false otherwise
            return $success;
        }
    }
?>
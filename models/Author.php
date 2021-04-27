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
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Close connection
            $statement->closeCursor();

            // Return results
            return $rows;
        }

        /**
         *  Obtains specific record based on id and set the object's properties
         *  @return {Array} - An associative array for the record found in DB
         */
        public function read_single() {
            $query = 'SELECT id, ' . $this->col_name .
                        ' FROM ' . $this->table .
                        ' WHERE id = :id LIMIT 1';
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
         *  @return {bool} - True if new record added to database, false otherwise
         */
        public function create() {
            $query = 'INSERT INTO  '. $this->table . ' (' . $this->col_name . ')' .
                        ' VALUES (:name)';

            try {
                $statement = $this->conn->prepare($query);

                // Bind data
                $statement->bindParam(':name', $this->name);

                // Execute query
                if($statement->execute() && ($statement->rowCount() > 0)) {
                    return true;
                } else {
                    return false;
                }

            } catch (PDOException $e) {
                // Display error if something goes wrong
                printf("Error: [%s].\n", $e->getMessage());
                return false;

            } finally {
                // Close connection
               $statement->closeCursor();
            }
        }

        /**
         *  Updates the record in the table in database
         *  @return {bool|int} - True if query execution was successful and affected >1 row in DB.
         *                       Returns it query executed but no rows affected.
         *                       Returns a status code if encounter PDOException error.
         */
        public function update() {
            // If the record with specific id doesn't exist, no need to update
            if (!$this->read_single()) {
                return false;
            }

            $query = 'UPDATE ' . $this->table .
                        ' SET ' . $this->col_name . ' = :name' .
                        ' WHERE id = :id';

            try {
                $statement = $this->conn->prepare($query);

                // Bind data
                $statement->bindParam(':name', $this->name);
                $statement->bindParam(':id', $this->id);

                // Execute query
                if($statement->execute()) {
                    return true;
                }

            } catch (PDOException $e) {
                // Display error if something goes wrong
                printf("Error: [%s].\n", $e->getMessage());

                switch($e->errorInfo[1]) {
                    case 1062:
                        return 409;     // Status Code 409 Conflict
                        break;
                }

            } finally {
                // Close connection
                $statement->closeCursor();
            }
        }

        /**
         *  Deletes a record from database based on id
         *  @return {bool} - True if record was deleted, false otherwise
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
                // Display error if something goes wrong
                printf("Error: [%s].\n", $e->getMessage());
                return false;

            } finally {
                // Close connection
                $statement->closeCursor();
            }
        }
    }
?>
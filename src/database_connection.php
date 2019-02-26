<?php
declare(strict_types=1);

namespace amadden;

/**
 * database_connection is responsible for connecting to, and querying a database
 * containing user data.
 */
class database_connection {
    private $conn;

    public function __construct(string $user, string $password, string $host, string $database = "") {
        $this->conn = $this->makeConnection($user, $password, $host, $database);
    }

    /**
     * Connects to a PostgreSQL database. Can be hosted locally or remotely.
     * If the database has a different name than the user, the dbname must be provided.
     *
     * @param string $user
     * @param string $password
     * @param string $host
     * @param string $database
     * @return void
     */
    private function makeConnection(string $user, string $password, string $host, string $database) {
        if ($database === "") {
            $connectionString = "host=".$host." user=".$user." password=".$password;
        } else {            
            $connectionString = "host=".$host." user=".$user." password=".$password." dbname=".$database;
        }
        pg_connect($connectionString) or die('Could not connect to database: ' . pg_last_error() . "\n");
    }

    /**
     * Returns the connection stored in a private variable
     *
     * @return $conn
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Attempts to create a new table in the database if it does not already exist.
     *
     * @return void
     */
    public function createUserTable() {
        $query = "CREATE TABLE IF NOT EXISTS users (
            email VARCHAR(255) PRIMARY KEY,
            name VARCHAR(255),
            surname VARCHAR(255)
            )";
        $result = pg_query($query) or die('Could not create new user table: ' . pg_last_error());
    }

    /**
     * Inserts a new user into the database
     *
     * @param user $user
     * @return void
     */
    public function insertUser(user $user) {
        $query = "INSERT INTO users (email, name, surname) VALUES ($1, $2, $3)";
        $result = @pg_query_params($query, [$user->email, $user->name, $user->surname])
            or die('Could not insert user with email: ' . $user->email . ". " . \pg_last_error());
    }

    /**
     * Gets a list of emails that are currently associated with users in the database
     *
     * @return array
     */
    public function getUserEmails(): array {
        $query = "SELECT email FROM users";
        $result = pg_query($query);
        $resultArray = pg_fetch_all($result);
        // If there are no results return an empty array, otherwise return a single array
        if ($resultArray == false) {
            $resultArray = [];
        } else {
            $resultArray = array_column($resultArray, "email");
        }
        return $resultArray;
    }

}
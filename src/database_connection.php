<?php
declare(strict_types=1);

namespace amadden;

class database_connection {
    private $conn;

    public function __construct(string $user, string $password, string $host) {
        $this->conn = $this->makeConnection($user, $password, $host);
    }

    private function makeConnection(string $user, string $password, string $host) {
        $connectionString = "host=".$host." user=".$user." password=".$password;
        pg_connect($connectionString) or die('Could not connect to database: ' . pg_last_error());
    }

    public function getConnection() {
        return $this->conn;
    }

    public function createUserTable() {
        $query = "CREATE TABLE IF NOT EXISTS users (
            email VARCHAR(255) PRIMARY KEY,
            name VARCHAR(255),
            surname VARCHAR(255)
            )";
        $result = pg_query($this->conn, $query) or die('Could not create new user table: ' . pg_last_error());
    }

    public function insertUser(user $user) {
        $query = "INSERT INTO users (email, name, surname) VALUES ($1, $2, $3)";
        $result = pg_query_params($this->conn, $query, [$user->email, $user->name, $user->surname])
            or die('Could not insert user with email: ' . $user->email . ". " . \pg_last_error());
    }

}
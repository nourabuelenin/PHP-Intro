<?php
class Database {
    private $connection;

    // Constructor to initialize the connection
    public function __construct($host, $user, $password, $database) {
        $this->connect($host, $user, $password, $database);
    }

    // Method to connect to the database
    public function connect($host, $user, $password, $database) {
        $this->connection = mysqli_connect($host, $user, $password, $database);
        if (!$this->connection) {
            throw new Exception("Connection failed: " . mysqli_connect_error());
        }
    }

    // Method to insert data into a table
    public function insert($table, $columns, $values) {
        $columns_str = implode(", ", $columns);
        $placeholders = implode(", ", array_fill(0, count($values), "?"));
        $query = "INSERT INTO $table ($columns_str) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(str_repeat("s", count($values)), ...$values);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Method to select data from a table
    public function select($table, $columns = "*", $condition = "") {
        $query = "SELECT $columns FROM $table";
        if (!empty($condition)) {
            $query .= " WHERE $condition";
        }
        $result = $this->connection->query($query);
        if (!$result) {
            throw new Exception("Error fetching data: " . $this->connection->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method to update data in a table
    public function update($table, $id, $fields) {
        $set_clause = implode(", ", array_map(fn($field) => "$field = ?", array_keys($fields)));
        $query = "UPDATE $table SET $set_clause WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $values = array_values($fields);
        $values[] = $id;
        $stmt->bind_param(str_repeat("s", count($values)), ...$values);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Method to delete data from a table
    public function delete($table, $id) {
        $query = "DELETE FROM $table WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Method to close the connection
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

// Initialize the database connection
$host = 'localhost';
$user = 'root';
$password = '2001';
$database = 'user_system';

try {
    $db = new Database($host, $user, $password, $database);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
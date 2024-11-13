<?php

class Sql {

    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "sa", "root");
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Bind parameters to SQL statement
    private function setParams(PDOStatement $stmt, array $parameters = []) {
        foreach ($parameters as $key => $value) {
            $this->setParam($stmt, $key, $value);
        }
    }

    // Bind a single parameter
    private function setParam(PDOStatement $stmt, $key, $value) {
        $stmt->bindParam($key, $value);
    }

    // Execute a query (e.g., INSERT, UPDATE, DELETE)
    public function query(string $rawQuery, array $params = []): PDOStatement {
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt, $params);
        $stmt->execute();
        return $stmt;
    }

    // Execute a SELECT query and return the result as an array
    public function select(string $rawQuery, array $params = []): array {
        $stmt = $this->query($rawQuery, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

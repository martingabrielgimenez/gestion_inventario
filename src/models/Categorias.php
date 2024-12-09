<<?php
require_once __DIR__ . '/../config/db.php';

class Category {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM categories ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name) {
        try {
            $stmt = $this->conn->prepare("SELECT id FROM categories WHERE name = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $existingCategory = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existingCategory) {
                echo "La categoría ya existe.\n";
                return false; 
            }
    
            // Si no existe, crear la categoría
            $query = "INSERT INTO categories (name) VALUES (:name)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Mostrar el error para depuración
            return false;
        }
    }
    
    public function update($id, $name) {
        $query = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getById($id) {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($query);  // Usamos $this->conn, no $this->db
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve un array con los datos de la categoría
    }

    public function deleteByName($name) {
        $query = "DELETE FROM categories WHERE name = :name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }
}

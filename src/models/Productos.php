<?php
require_once __DIR__ . '/../config/db.php';

class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT products.*, categories.name AS category_name
                  FROM products
                  JOIN categories ON products.category_id = categories.id
                  ORDER BY products.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalCount() {
        $query = "SELECT COUNT(*) FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['COUNT(*)'];  // Devuelve el total de productos
    }

    public function getCategoryCount() {
        $query = "SELECT COUNT(DISTINCT category_id) FROM products";  // Cuenta categorías únicas
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['COUNT(DISTINCT category_id)'];  // Devuelve el total de categorías distintas
    }

    // Método para obtener productos con bajo stock
    public function getLowStock($threshold = 10) {
        // Consulta para obtener productos con stock menor que el umbral
        $query = "SELECT * FROM products WHERE stock < :threshold";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':threshold', $threshold, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Devuelve los productos con bajo stock
    }

    public function getById($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve un solo producto
    }

    public function create($name, $category_id, $stock, $price) {
        $query = "INSERT INTO products (name, category_id, stock, price) VALUES (:name, :category_id, :stock, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function update($id, $name, $category_id, $stock, $price) {
        $query = "UPDATE products SET name = :name, category_id = :category_id, stock = :stock, price = :price WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        try {
            // Eliminar las filas de la tabla 'inventario' que hacen referencia al producto
            $query = "DELETE FROM inventario WHERE product_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
    
            // Ahora eliminar el producto de la tabla 'products'
            $query = "DELETE FROM products WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

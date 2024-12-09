<?php
require_once __DIR__ . '/../config/db.php';

class Inventario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($data) {
        // Lógica para registrar entrada o salida de inventario
        if ($data['type'] == 'out') {
            // Verificar si hay suficiente stock
            $stmt = $this->conn->prepare("SELECT stock FROM products WHERE id = :product_id");
            $stmt->bindParam(':product_id', $data['product_id']);
            $stmt->execute();
            $currentStock = $stmt->fetchColumn();
    
            if ($currentStock < $data['quantity']) {
                return false; 
            }
        }
    
        // Proceder con la operación de inventario (entrada o salida)
        $query = "INSERT INTO inventario (product_id, type, quantity) VALUES (:product_id, :type, :quantity)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $data['product_id']);
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':quantity', $data['quantity']);
        return $stmt->execute();
    }
    

    // Registrar una entrada o salida
    public function create($product_id, $type, $quantity) {
        // Registrar el movimiento en la tabla inventario
        $query = "INSERT INTO inventario (product_id, type, quantity) 
                  VALUES (:product_id, :type, :quantity)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':quantity', $quantity);

        if ($stmt->execute()) {
            // Actualizar el stock del producto
            $updateStockQuery = ($type === 'in') 
                ? "UPDATE products SET stock = stock + :quantity WHERE id = :product_id"
                : "UPDATE products SET stock = stock - :quantity WHERE id = :product_id";

            $updateStmt = $this->conn->prepare($updateStockQuery);
            $updateStmt->bindParam(':quantity', $quantity);
            $updateStmt->bindParam(':product_id', $product_id);
            return $updateStmt->execute();
        }
        return false;
    }

    // Método para contar el total de movimientos en inventario
    public function getMovementCount() {
    $query = "SELECT COUNT(*) AS total FROM inventario";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
    }

    // Obtener todos los movimientos
    public function getAll() {
        $query = "SELECT inventario.*, products.name AS product_name 
                  FROM inventario
                  JOIN products ON inventario.product_id = products.id
                  ORDER BY inventario.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Metodo para calcular los productos mas vendidos
    public function getTopSelling($limit = 5) {
        $query = "
            SELECT p.id, p.name, SUM(i.quantity) AS total_sold
            FROM products p
            LEFT JOIN inventario i ON p.id = i.product_id
            GROUP BY p.id
            ORDER BY total_sold DESC
            LIMIT :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

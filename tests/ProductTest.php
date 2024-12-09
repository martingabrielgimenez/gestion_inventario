<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/models/Productos.php';
require_once __DIR__ . '/../src/config/db.php';

class ProductTest extends TestCase {
    private $db;
    private $product;

    protected function setUp(): void {
        $this->db = (new Database())->connect();
        $this->product = new Product($this->db);

    $stmt = $this->db->prepare("INSERT IGNORE INTO category (id, name) VALUES (1, 'Categoría Test')");
    $stmt->execute();
    }

    public function testCreateProductSuccess() {
        $categoryName = 'Electronics';
        
        // Verificar si la categoría ya existe
        $stmt = $this->db->prepare("SELECT id FROM category WHERE name = :name");
        $stmt->bindParam(':name', $categoryName);
        $stmt->execute();
        
        // Obtener el id de la categoría si existe
        $categoryId = $stmt->fetchColumn();
        
        if (!$categoryId) {
            $stmt = $this->db->prepare("INSERT INTO category (name) VALUES (:name)");
            $stmt->bindParam(':name', $categoryName);
            $stmt->execute();
            $categoryId = $this->db->lastInsertId();  // Obtener el ID de la categoría recién insertada
        }
        
        $productName = 'Smartphone';
        $stock = 10;
        $price = 299.99;
        
        // Insertar el producto
        $stmt = $this->db->prepare("INSERT INTO products (name, category_id, stock, price) VALUES (:name, :category_id, :stock, :price)");
        $stmt->bindParam(':name', $productName);
        $stmt->bindParam(':category_id', $categoryId);  // Usar el ID de categoría válido
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':price', $price);
        
        // Ejecutar la inserción del producto
        if ($stmt->execute()) {
            $this->assertTrue(true, "El producto debería crearse correctamente.");
        } else {
            $this->fail("Error al insertar el producto: " . implode(", ", $stmt->errorInfo()));
        }
    }
    
    

    public function testCreateProductInvalidCategory() {
        $invalidCategoryId = 999; // ID de categoría que no existe
        
        $productName = 'Nuevo Producto';
        $stock = 50;
        $price = 150.00;
        
        // Intentar insertar el producto con un ID de categoría no válido
        try {
            $stmt = $this->db->prepare("INSERT INTO products (name, category_id, stock, price) VALUES (:name, :category_id, :stock, :price)");
            $stmt->bindParam(':name', $productName);
            $stmt->bindParam(':category_id', $invalidCategoryId);  // ID inválido
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':price', $price);
            $stmt->execute();
        
            // Si llega aca, la inserción no falló, por lo tanto es un error en la prueba
            $this->fail("No debería permitir la creación del producto con un category_id inválido.");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
            
            // Comprobar que el error corresponde a una violación de clave foránea
            $this->assertStringContainsString("FOREIGN KEY", $e->getMessage(), "El error no corresponde a una violación de clave foránea.");
        }
    }
    
    
    
    
    
}

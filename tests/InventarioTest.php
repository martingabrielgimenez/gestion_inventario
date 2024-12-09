<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/models/Inventario.php';
require_once __DIR__ . '/../src/config/db.php';

class InventarioTest extends TestCase {
    private $db;
    private $inventario;

    protected function setUp(): void {
        $this->db = (new Database())->connect();
        $this->inventario = new Inventario($this->db);
    
        // Verificar si la categoría con ID 1 existe
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM category WHERE id = 1");
        $stmt->execute();
        $categoryCount = $stmt->fetchColumn();
    
        if ($categoryCount == 0) {
            $stmt = $this->db->prepare("INSERT INTO category (id, name) VALUES (1, 'Categoría de prueba')");
            $stmt->execute();
        }
    
        // Verificar si el producto con ID 1 existe
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM products WHERE id = 1");
        $stmt->execute();
        $productCount = $stmt->fetchColumn();
    
        if ($productCount == 0) {
            $stmt = $this->db->prepare("INSERT INTO products (id, name, category_id, stock, price) VALUES (1, 'Producto de prueba', 1, 100, 10.00)");
            $stmt->execute();
        }
    }
    

    public function testRegisterInventoryInSuccess() {
        $data = [
            'product_id' => 1,
            'type' => 'in',
            'quantity' => 50
        ];

        $result = $this->inventario->register($data);

        $this->assertTrue($result, "Debería registrar correctamente una entrada de inventario.");
    }

    public function testRegisterInventoryOutInvalidStock() {
        $data = [
            'product_id' => 1,
            'type' => 'out',
            'quantity' => 5000 // Cantidad mayor al stock disponible
        ];

        $result = $this->inventario->register($data);

        $this->assertFalse($result, "No debería permitir una salida de inventario con stock insuficiente.");
    }
}
?>

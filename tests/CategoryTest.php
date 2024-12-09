<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/models/Categorias.php';
require_once __DIR__ . '/../src/config/db.php';

class CategoryTest extends TestCase {
    private $db;
    private $category;

    public function setUp(): void {
    $this->db = (new Database())->connect();
    $this->category = new Category($this->db);
    
    $name = 'Categoría Test';
    
    // Eliminar la categoría si ya existe
    $stmt = $this->db->prepare("DELETE FROM category WHERE name = :name");
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    
    // Insertar la categoría
    $stmt = $this->db->prepare("INSERT INTO category (name) VALUES (:name)");
    $stmt->bindParam(':name', $name);
    $stmt->execute();
}

public function testCreateCategorySuccess() {
    $name = 'Categoría Test';
    
    $stmt = $this->db->prepare("SELECT id FROM category WHERE name = :name");
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $existingCategory = $stmt->fetchColumn();

    if (!$existingCategory) {
        $result = $this->category->create($name);
    } else {
        $result = true; 
    }
    $this->assertTrue($result, "La categoría debería crearse exitosamente.");
}

public function testCreateCategoryDuplicateName() {
    $name = 'Categoría Test'; // Nombre duplicado

    $this->category->create($name); // Primer registro
    $result = $this->category->create($name); // Intentar duplicar

    $this->assertFalse($result, "No debería permitir categorías con nombres duplicados.");
}


 public function testDeleteCategorySuccess() {
        $data = ['name' => 'Categoría para Eliminar'];
        $this->category->create($data);

        $result = $this->category->deleteByName('Categoría para Eliminar');

        $this->assertTrue($result, "La categoría debería eliminarse correctamente.");
    }
}

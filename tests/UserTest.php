<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/models/User.php';
require_once __DIR__ . '/../src/config/db.php';

class UserTest extends TestCase {
    private $db;
    private $user;

    protected function setUp(): void {
        $this->db = (new Database())->connect();
        $this->user = new User($this->db);
    }

    public function testRegisterUserSuccess() {
        $username = "testuser" . uniqid();
        $password = "securepassword";
        $role = "user";
    
        $result = $this->user->register($username, $password, $role);
    
        $this->assertEquals('Usuario registrado correctamente.', $result, "El registro debería ser exitoso.");
    }
    

    public function testRegisterUserDuplicateUsername() {
        $username = "testuser"; // Intenta registrar un usuario ya existente
        $password = "anotherpassword";
        $role = "user";
    
        $result = $this->user->register($username, $password, $role);
    
        $this->assertEquals('El usuario ya existe.', $result, "No debería permitir registros con nombres de usuario duplicados.");
    }
    
}

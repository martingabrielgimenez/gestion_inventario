<?php
require_once __DIR__ . '/../config/db.php';

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $password, $role = 'user') {
        $query = "SELECT COUNT(*) FROM user WHERE username = :username"; // Cambié user a users
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            return "El usuario ya existe."; // Mensaje más claro
        }
    
        // Insertar el nuevo usuario
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (username, password, role) VALUES (:username, :password, :role)"; // Cambié user a users
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role); // Al registrar pasa el rol
        if ($stmt->execute()) {
            return "Usuario registrado correctamente.";
        }
        return "Error al registrar el usuario.";
    }

    public function authenticate($username, $password) {
        $query = "SELECT * FROM user WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
?>

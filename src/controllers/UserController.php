<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/Validator.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function register($username, $password, $role = 'user') {
        $validator = new Validator();

        $validator->required('username', $username, "El usuario es obligatorio.");
        $validator->minLength('username', $username, 4, "El usuario debe tener al menos 4 caracteres.");
        $validator->required('password', $password, "La contraseña es obligatoria.");
        $validator->minLength('password', $password, 6, "La contraseña debe tener al menos 6 caracteres.");
        $validator->inArray('role', $role, ['admin', 'user'], "El rol es inválido.");

        if ($validator->hasErrors()) {
            return $validator->getErrors();
        }

        return $this->userModel->register($username, $password, $role);
    }

    public function login($username, $password) {
        $user = $this->userModel->authenticate($username, $password); 
    
        if ($user) {
            // Crear una sesión para el usuario
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role']; // Almacenar el rol en la sesión
            return true; 
        } else {
            return false; 
        }
    }
    
    
}
?>

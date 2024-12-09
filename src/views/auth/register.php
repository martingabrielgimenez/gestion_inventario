<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/UserController.php';
require_once __DIR__ . '/../../helpers/Validator.php';

$db = (new Database())->connect();
$userController = new UserController($db);

$errors = []; // Array para almacenar los errores de validación

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validar datos de entrada
    $validator = new Validator();
    $validator->required('username', $username, "El usuario es obligatorio.");
    $validator->minLength('username', $username, 4, "El usuario debe tener al menos 4 caracteres.");
    $validator->required('password', $password, "La contraseña es obligatoria.");
    $validator->minLength('password', $password, 6, "La contraseña debe tener al menos 6 caracteres.");
    $validator->inArray('role', $role, ['admin', 'user'], "El rol seleccionado no es válido.");

    if ($validator->hasErrors()) {
        $errors = $validator->getErrors();
    } else {
        if ($userController->register($username, $password, $role)) {
            header('Location: login.php');
        } else {
            $errors['general'] = ["Error al registrar el usuario."];
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventario/public/css/style.css">

    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registrar Usuario</h1>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $field => $messages): ?>
                <?php foreach ($messages as $message): ?>
                    <li><?= $message ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
        <br><br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <label for="role">Rol:</label>
        <select name="role" id="role">
            <option value="user" <?= (isset($_POST['role']) && $_POST['role'] === 'user') ? 'selected' : '' ?>>Usuario</option>
            <option value="admin" <?= (isset($_POST['role']) && $_POST['role'] === 'admin') ? 'selected' : '' ?>>Administrador</option>
        </select>
        <br><br>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>


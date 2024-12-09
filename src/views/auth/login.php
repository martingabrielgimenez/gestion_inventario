<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/UserController.php';

$db = (new Database())->connect();
$userController = new UserController($db);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $userController->login($username, $password);
    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: ../dashboard/index.php');
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventario/public/css/style.css">

    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <form action="" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>

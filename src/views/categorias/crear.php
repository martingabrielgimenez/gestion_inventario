<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/CategoriasController.php';

$db = (new Database())->connect();
$controller = new CategoryController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    if ($controller->store($name)) {
        header('Location: index.php');
    } else {
        echo "Error al crear la categoría.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventario/public/css/style.css">
    <title>Crear Categoría</title>
</head>
<body>
    <h1>Crear Nueva Categoría</h1>
    <form action="" method="POST">
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" required>
        <button type="submit">Guardar</button>
    </form>
    <a href="index.php">Volver</a>
</body>
</html>

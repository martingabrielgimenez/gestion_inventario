<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/CategoriasController.php';

$db = (new Database())->connect();
$controller = new CategoryController($db);
$categories = $controller->index();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventario/public/css/style.css">
    <title>Gestión de Categorías</title>
</head>
<body>
    <h1>Lista de Categorías</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id'] ?></td>
                <td><?= $category['name'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $category['id'] ?>">Editar</a>
                    <a href="eliminar.php?id=<?= $category['id'] ?>">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="create.php">Crear Nueva Categoría</a>
</body>
</html>

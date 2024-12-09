<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/ProductosController.php';

$db = (new Database())->connect();
$controller = new ProductController($db);
$products = $controller->index();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventario/public/css/style.css">
    <title>Gestión de Productos</title>
</head>

<body>
    
    <h1>Lista de Productos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= $product['name'] ?></td>
                <td><?= $product['category_name'] ?></td>
                <td><?= $product['stock'] ?></td>
                <td><?= $product['price'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $product['id'] ?>">
                        <button type="button">Editar</button>
                    </a>
                    <form action="eliminar.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="create.php">Crear nuevo producto</a> <br>
    <a href="/inventario/src/views/dashboard/index.php">Volver al Panel</a>

    
</body>
</html>

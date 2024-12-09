<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/InventarioController.php';

$db = (new Database())->connect();
$controller = new InventarioController($db);
$movements = $controller->index();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventario/public/css/style.css">

    <title>Movimientos de Inventario</title>
</head>
<body>
    <h1>Movimientos de Inventario</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movements as $movement): ?>
            <tr>
                <td><?= $movement['id'] ?></td>
                <td><?= $movement['product_name'] ?></td>
                <td><?= $movement['type'] === 'in' ? 'Entrada' : 'Salida' ?></td>
                <td><?= $movement['quantity'] ?></td>
                <td><?= $movement['created_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="create.php">Registrar Movimiento</a>
</body>
</html>

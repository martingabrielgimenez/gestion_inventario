<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/DashboardController.php';

$db = (new Database())->connect();
$dashboardController = new DashboardController($db);

$generalStats = $dashboardController->getGeneralStats();
$lowStockProducts = $dashboardController->getLowStockProducts();
$topSellingProducts = $dashboardController->getTopSellingProducts();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventario/public/css/style.css">
    <title>Panel de Control</title>
</head>
<body>
    <h1>Panel de Control</h1>

    <h2>Estadísticas generales</h2>
    <ul>
        <li>Total de productos: <?= $generalStats['total_products'] ?></li>
        <li>Total de categorías: <?= $generalStats['total_categories'] ?></li>
        <li>Total de movimientos: <?= $generalStats['total_movements'] ?></li>
    </ul>

    <h2>Productos con bajo stock</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lowStockProducts as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= $product['name'] ?></td>
                <td><?= $product['stock'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Productos más vendidos</h2>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Vendidos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($topSellingProducts as $product): ?>
            <tr>
                <td><?= $product['name'] ?></td>
                <td><?= $product['total_sold'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        
    <div class="centered-container">
    <a href="/inventario/src/views/productos/index.php">
        <h2>Ingresar a la Lista/Gestión de Productos</h2>
    </a>
</div>    
</body>
</html>

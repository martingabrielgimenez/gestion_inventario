<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/InventarioController.php';
require_once __DIR__ . '/../../controllers/ProductosController.php';

$db = (new Database())->connect();
$inventarioController = new InventarioController($db);
$productController = new ProductController($db);
$products = $productController->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    if ($inventarioController->store($product_id, $type, $quantity)) {
        header('Location: index.php');
    } else {
        echo "Error al registrar el movimiento.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventario/public/css/style.css">

    <title>Registrar Movimiento</title>
</head>
<body>
    <h1>Registrar Movimiento de Inventario</h1>
    <form action="" method="POST">
        <label for="product">Producto:</label>
        <select name="product_id" id="product" required>
            <?php foreach ($products as $product): ?>
            <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <label for="type">Tipo:</label>
        <select name="type" id="type" required>
            <option value="in">Entrada</option>
            <option value="out">Salida</option>
        </select>
        <label for="quantity">Cantidad:</label>
        <input type="number" name="quantity" id="quantity" min="1" required>
        <button type="submit">Registrar</button>
    </form>
    <a href="index.php">Volver</a>
</body>
</html>

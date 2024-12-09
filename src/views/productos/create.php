<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/ProductosController.php';
require_once __DIR__ . '/../../controllers/CategoriasController.php';

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: no_auth.php'); // Redirige si no es admin
    exit();
}

$db = (new Database())->connect();
$productController = new ProductController($db);
$categoryController = new CategoryController($db);
$categories = $categoryController->index();

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    // Intentar crear el producto
    if ($productController->store($name, $category_id, $stock, $price)) {
        header('Location: index.php');
        exit();
    } else {
        $error = "Error al crear el producto. Por favor, intenta de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/inventario/public/css/style.css">
    <title>Crear Producto</title>
</head>
<body>
    <h1>Crear nuevo Producto</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" required>

        <label for="category">Categoría:</label>
        <select name="category_id" id="category" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" min="0" required>

        <label for="price">Precio:</label>
        <input type="number" name="price" id="price" step="0.01" required>

        <button type="submit">Guardar</button>
    </form>
    <a href="index.php">Volver</a>
</body>
</html>

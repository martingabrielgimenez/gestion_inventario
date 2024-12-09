<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/ProductosController.php';

session_start();

// Verificar si el usuario está logueado y tiene el rol adecuado
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo '<p>No tienes permisos para acceder a esta sección.</p>';
    echo '<a href="/inventario/src/views/productos/index.php">Volver a la lista de productos</a>';
    exit();
    
    $db = (new Database())->connect();
    $productController = new ProductController($db);

    if (isset($_GET['id'])) {
        $product = $productController->getById($_GET['id']);
    }

    // Manejar la actualización del producto cuando se recibe el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $stock = $_POST['stock'];
        $price = $_POST['price'];

        // Actualizar el producto en la db
        if ($productController->update($_GET['id'], $name, $category_id, $stock, $price)) {
            header('Location: index.php');
        } else {
            $error = "Error al actualizar el producto.";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="/inventario/public/css/style.css">
            <title>Editar Producto</title>
        </head>
        <body>
            <h1>Editar Producto</h1>

            <?php if (isset($error)): ?>
                <p><?= $error ?></p>
            <?php endif; ?>

            <form method="POST">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" value="<?= $product['name'] ?>" required><br>

                <label for="category_id">Categoría</label>
                <input type="text" name="category_id" id="category_id" value="<?= $product['category_id'] ?>" required><br>

                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" value="<?= $product['stock'] ?>" required><br>

                <label for="price">Precio</label>
                <input type="text" name="price" id="price" value="<?= $product['price'] ?>" required><br>

                <button type="submit">Guardar Cambios</button>
            </form>
        </body>
    </html>

<?php
}
?>

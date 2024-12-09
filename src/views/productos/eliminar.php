<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../controllers/ProductosController.php';

$db = (new Database())->connect();
$productController = new ProductController($db);

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Verificar si el ID es numérico
    if (is_numeric($id)) {
        if ($productController->destroy($id)) {
            header('Location: index.php');
            exit;
        } else {
            echo "Error al eliminar el producto.";
        }
    } else {
        echo "ID no válido.";
    }
} else {
    echo "No se proporcionó ID.";
}

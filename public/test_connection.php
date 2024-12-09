<?php
$host = 'localhost';
$db_name = 'inventario';
$username = 'root'; 
$password = ''; 

try {
    // Crear conexión PDO
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

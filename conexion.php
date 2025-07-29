<?php
// Datos de conexión
$host = 'localhost';
$dbname = 'ORGANIZACION';
$usuario = 'root';
$contrasena = ''; // En XAMPP, por defecto el root no tiene contraseña

try {
    // Creamos la conexión con PDO
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $contrasena);

    // Configuramos para que nos muestre los errores si algo falla
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Confirmamos la conexión
    echo "Conexión exitosa a la base de datos ORGANIZACION.";

} catch (PDOException $e) {
    // En caso de error, lo mostramos
    echo "Error de conexión: " . $e->getMessage();
}
?>

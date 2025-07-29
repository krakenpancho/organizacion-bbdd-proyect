<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];

    $sql = "INSERT INTO DONANTE (nombre, email, direccion, telefono) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$nombre, $email, $direccion, $telefono]);

    echo "Donante guardado exitosamente.";
}
?>

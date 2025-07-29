<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $presupuesto = $_POST["presupuesto"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    $sql = "INSERT INTO PROYECTO (nombre, descripcion, presupuesto, fecha_inicio, fecha_fin) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $presupuesto, $fecha_inicio, $fecha_fin]);

    echo "Proyecto guardado exitosamente.";
}
?>

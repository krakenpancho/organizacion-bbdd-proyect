<?php
require 'conexion.php';

$sql = "SELECT * FROM DONANTE";
$resultado = $conexion->query($sql);

echo "<h2>Lista de Donantes</h2>";
foreach ($resultado as $fila) {
    echo "Nombre: " . $fila["nombre"] . " - Email: " . $fila["email"] . "<br>";
}
?>

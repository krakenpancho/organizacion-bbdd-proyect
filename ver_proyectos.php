<?php
require 'conexion.php';

$sql = "SELECT * FROM PROYECTO";
$resultado = $conexion->query($sql);

echo "<h2>Lista de Proyectos</h2>";
foreach ($resultado as $fila) {
    echo "Nombre: " . $fila["nombre"] . " - Presupuesto: $" . $fila["presupuesto"] . "<br>";
}
?>

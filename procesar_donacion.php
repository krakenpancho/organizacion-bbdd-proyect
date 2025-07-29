<?php
// Incluir archivo de conexión
require_once 'conexion.php';

// Verificar que se recibieron los datos
if (!isset($_POST['id_donante']) || !isset($_POST['proyectos_seleccionados']) || !isset($_POST['montos']) || !isset($_POST['fecha'])) {
    die("Error: Faltan datos del formulario.");
}

$id_donante = $_POST['id_donante'];
$proyectos_seleccionados = $_POST['proyectos_seleccionados']; // array de IDs de proyectos
$montos = $_POST['montos']; // array asociativo [id_proyecto => monto]
$fecha = $_POST['fecha'];

try {
    // Comenzar transacción para que todas las donaciones se guarden o ninguna
    $conexion->beginTransaction();
    
    $donaciones_exitosas = 0;
    
    // Insertar una donación por cada proyecto seleccionado
    foreach ($proyectos_seleccionados as $id_proyecto) {
        // Verificar que el proyecto tenga un monto asignado
        if (isset($montos[$id_proyecto]) && $montos[$id_proyecto] > 0) {
            $monto = $montos[$id_proyecto];
            
            // Preparar la consulta
            $stmt = $conexion->prepare("INSERT INTO DONACION (monto, fecha, id_proyecto, id_donante) VALUES (?, ?, ?, ?)");
            $stmt->execute([$monto, $fecha, $id_proyecto, $id_donante]);
            
            $donaciones_exitosas++;
        }
    }
    
    // Confirmar la transacción
    $conexion->commit();
    
    echo "<h2>¡Donaciones registradas correctamente!</h2>";
    echo "<p>Se registraron <strong>$donaciones_exitosas</strong> donaciones.</p>";
    echo "<br><a href='menu.html'>Volver al menú</a>";
    echo "<br><a href='registrar_donaciones.php'>Registrar otra donación</a>";
    
} catch (PDOException $e) {
    // Si hay error, cancelar todas las operaciones
    $conexion->rollBack();
    echo "Error al registrar las donaciones: " . $e->getMessage();
}
?>

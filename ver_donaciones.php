<?php
require 'conexion.php';

// Verificar si se debe aplicar el filtro
$filtro_activo = isset($_GET['filtro']) && $_GET['filtro'] == 'mas_de_dos';

try {
    $sql = "
        SELECT 
            p.nombre AS nombre_proyecto,
            COUNT(d.id_donacion) AS cantidad_donaciones,
            IFNULL(SUM(d.monto), 0) AS monto_total
        FROM proyecto p
        LEFT JOIN donacion d ON p.id_proyecto = d.id_proyecto
        GROUP BY p.id_proyecto, p.nombre
    ";
    
    // Agregar filtro si está activado
    if ($filtro_activo) {
        $sql .= " HAVING COUNT(d.id_donacion) > 2";
    }
    
    $sql .= " ORDER BY monto_total DESC";

    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $donaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al consultar las donaciones: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Donaciones</title>
    <style>
        .filtros {
            background-color: #f0f0f0;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .boton-filtro {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .boton-activo {
            background-color: #007bff;
            color: white;
        }
        .boton-inactivo {
            background-color: #6c757d;
            color: white;
        }
        .info-filtro {
            margin-top: 10px;
            font-style: italic;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <h1>Resumen de Donaciones por Proyecto</h1>
    <div style="margin-bottom: 20px;"></div>
        <a href="menu.html" class="boton-filtro boton-activo" style="background-color: #28a745;">
            🏠 Volver al Menú Principal
        </a>
    </div>
    <!-- Panel de Filtros -->
    <div class="filtros">
        <h3>Filtros de Consulta</h3>
        <p><strong>Consulta Avanzada:</strong> Mostrar proyectos con más de 2 donaciones registradas</p>
        
        <?php if ($filtro_activo): ?>
            <span class="boton-filtro boton-activo">
                ✅ Filtro Activo: Más de 2 Donaciones
            </span>
            <a href="ver_donaciones.php" class="boton-filtro boton-inactivo">
                🔄 Mostrar Todos los Proyectos
            </a>
        <?php else: ?>
            <a href="ver_donaciones.php?filtro=mas_de_dos" class="boton-filtro boton-activo">
                🔍 Aplicar Filtro: Más de 2 Donaciones
            </a>
            <span class="boton-filtro boton-inactivo">
                📋 Mostrando Todos los Proyectos
            </span>
        <?php endif; ?>
        
        <div class="info-filtro">
            <?php if ($filtro_activo): ?>
                <strong>Filtro aplicado:</strong> Solo proyectos con más de 2 donaciones registradas
            <?php else: ?>
                <strong>Vista actual:</strong> Todos los proyectos (incluyendo los que no tienen donaciones)
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Tabla de Resultados -->
    <table>
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Cantidad de Donaciones</th>
                <th>Monto Total Donado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($donaciones) > 0): ?>
                <?php foreach ($donaciones as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['nombre_proyecto']) ?></td>
                        <td><?= $fila['cantidad_donaciones'] ?></td>
                        <td>$<?= number_format($fila['monto_total'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align: center; color: #666; font-style: italic;">
                        <?php if ($filtro_activo): ?>
                            No hay proyectos con más de 2 donaciones registradas.
                        <?php else: ?>
                            No hay proyectos registrados.
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <!-- Resumen -->
    <div style="margin-top: 20px; padding: 10px; background-color: #e9ecef; border-radius: 5px;">
        <strong>Resumen:</strong> 
        <?php if ($filtro_activo): ?>
            Se encontraron <strong><?= count($donaciones) ?></strong> proyectos con más de 2 donaciones.
        <?php else: ?>
            Total de proyectos: <strong><?= count($donaciones) ?></strong>
        <?php endif; ?>
    </div>
</body>
</html>
